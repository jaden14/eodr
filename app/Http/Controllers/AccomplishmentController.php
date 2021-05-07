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
        $target = target::where('position', $user->FPOSITION)->where('office_id', $user->office_id)->get();


    	if($user->user_type =='administrator') {

    		$accomplishment = $this->model->orderBy('date','desc')->paginate(20);

    	} elseif($user->user_type =='Supervisor') {

    		$accomplishment = $this->model->with('user')->WhereHas('user', function ($q) use ($user) {
                    return $q->where('office_id',$user->office_id);
                })->orderBy('date','desc')->orderBy('date','desc')->paginate(20);;

    	} else {

            $accomplishment = $this->model->with('user')->where('user_id', $user->id)->orderBy('date','desc')->paginate(20);
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

    		if($request->search && $request->search2) {

    		$accomplishment = $this->model->Wherebetween('date',[$request->search, $request->search2])->where('user_id', $user->id);

    		}

    		if( $request->search == null || $request->search2 == null) {

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


            $dates = $request->date;
            $dated = $request->dated;


            for($dates; $dates <= $dated; $dates++)
            {

    		$data['date'] = $dates;
    		$data['natur_accomp'] = $request->natur_accomp;
    		$data['accomplishment'] = $request->accomplishment;
    		$data['quantity'] = $request->quantity;
    		$data['user_id'] = $request->id;
            $data['target_id'] = $request->target;
        	
        	$accomplishment = $this->model->create($data);

            if($request->target != null)
                {
                    $target = Target::find($request->target);

                    if($dates <= $target->period_from && $dates >= $target->period_to)

                    {   
                    $output['period_from'] = $target->period_from;
                    $output['period_to'] = $target->period_to;
                    $output['date'] = $dates;
                    $output['accomplishment_id'] = $accomplishment->id;
                    $output['target_id'] = $target->target;
                    $output['user_id'] = auth::user()->id;

                    Output::create($output);
                    }
                }

            }



    		return redirect('/accomplishment');
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

        $target = Output::where('accomplishment_id', $request->id)->first();

        if(!empty($target))
        {
            if($request->date <= $target->period_from && $request->date >= $target->period_to)
            {

                $target->date = $request->date;
                $target->target_id = $request->target_id;
                $target->update();
            }

        }

        if($request->target_id != null)
        {
            $target = Target::find($request->target_id);

            if($request->date <= $target->period_from && $request->date >= $target->period_to)
            { 

                    $output['period_from'] = $target->period_from;
                    $output['period_to'] = $target->period_to;
                    $output['date'] = $request->date;
                    $output['accomplishment_id'] = $accomplishment->id;
                    $output['target_id'] = $request->target_id;
                    $output['user_id'] = auth::user()->id;

                    Output::create($output);
            } 
        }


        return $accomplishment;
    }

    public function acc_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();

        $target = Output::where('accomplishment_id', $request->id)->first();

        if(!empty($target))
        {
            $target->delete();
        }

        $data->delete();

        return $data;
    }
}
