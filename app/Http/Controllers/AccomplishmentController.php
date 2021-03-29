<?php

namespace App\Http\Controllers;

use App\Division;
use App\Accomplishment;
use App\User;
use App\Office;
use Illuminate\Http\Request;
Use Carbon\Carbon;
use App\Target;
use App\Output;
use Auth;

class AccomplishmentController extends Controller
{
    public function __construct(Accomplishment $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$date = Carbon::now();
    	$user = auth::user();
        $users = User::where('office_id', $user->office_id)->get();
        $office = Office::orderBy('name','asc')->get();
        $division = division::orderBy('name','asc')->get();
        $target = Target::with('output')->orderBy('code','asc')->get();

    	if($user->user_type =='administrator') {

    		$accomplishment = $this->model->latest()->paginate(30);

    	} elseif($user->user_type =='Supervisor') {

    		$accomplishment = $this->model->with('user')->WhereHas('user', function ($q) use ($user) {
                    return $q->where('office_id',$user->office_id);
                })->orderBy('date','desc')->latest()->paginate(30);;

    	} else {

            $accomplishment = $this->model->with('user')->where('user_id', $user->id)->latest()->paginate(30);
        }
    	
        return view('accomplishment.index',compact('date','user','accomplishment','division','office','users','target'));
    }

    public function accomplishment_division(Request $request)
    {
    
        //if our chosen id and products table prod_cat_id col match the get first 100 data 

        //$request->id here is the id of our chosen option id
        $data=Division::select('name','id')->where('office_id',$request->id)->orderBy('name','asc')->get();

        return response()->json($data);//then sent this data to ajax success
    }

     public function searchs(Request $request)
    {
    	$date = Carbon::now();
    	$user = auth::user();
        $users = User::where('office_id', $user->office_id)->get();
        $office = Office::orderBy('name','asc')->get();
        $division = division::orderBy('name','asc')->get();
        $target = Target::with('output')->orderBy('code','asc')->get();
        $flast = $request->get('name');

    	if($user->user_type =='administrator') {

    		if( $request->search) {

    		$accomplishment = $this->model->Where('date',$request->search);
    		} 

    	       if( $request->search == null) {

            return redirect('/accomplishment');
            }

    	}  elseif($user->user_type == 'Supervisor') {
            
            if($flast) {
                $accomplishment = $this->model->WhereHas('user', function ($q) use ($flast) {
                    return $q->where('user_id', $flast);
                });
            }
        }


        else {

    		if( $request->search) {

    		$accomplishment = $this->model->Where('date',$request->search)->where('user_id', $user->id);

    		}

    		if( $request->search == null) {

            return redirect('/accomplishment');
       	 	}
    	}

        


    	$accomplishment = $accomplishment->paginate(30);
        return view('accomplishment.index',compact('date','user','accomplishment','division','office','users','target'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'office_id'  =>  'sometimes|required',
    			'division_id'  =>  'sometimes|required',
                'date'  =>  'required',
                'natur_accomp'  =>  'required',
                'accomplishment'  =>  'required',
            ]);

    	if($request->office_id != null)
    	{
    		$user = User::where('id', $request->id)->first();

            $user->office_id = $request->office_id;
            $user->division_id = $request->division_id;
    		$user->user_type = 'User';
    		$user->update();
    	}

    		$data['date'] = $request->date;
    		$data['natur_accomp'] = $request->natur_accomp;
    		$data['accomplishment'] = $request->accomplishment;
    		$data['quantity'] = $request->quantity;
    		$data['user_id'] = $request->id;
            $data['target_id'] = $request->target;
        	
        	$accomplishment = $this->model->create($data);

    		return $accomplishment;
    }

    public function acc_edit(Request $request) 
    {

        return $this->model->where('id', $request->id)->first();
    }

    public function acc_update(Request $request) 
    {
        $request->validate([
                'date'  =>  'required',
                'natur_accomp'  =>  'required',
                'accomplishment'  =>  'required',
            ]);

        $accomplishment = $this->model->where('id', $request->id)->first();

        $accomplishment->update($request->all());

        return $accomplishment;
    }

    public function acc_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
