<?php

namespace App\Http\Controllers;

use App\Accomplishment;
use App\User;
use Illuminate\Http\Request;
Use Carbon\Carbon;
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

    	if($user->user_type =='administrator') {

    		$accomplishment = $this->model->latest()->paginate(30);
    	} else {
    		$accomplishment = $this->model->with('user')->where('user_id', $user->id)->latest()->paginate(30);
    	}
    	
        return view('Accomplishment.index',compact('date','user','accomplishment'));
    }

     public function searchs(Request $request)
    {
    	$date = Carbon::now();
    	$user = auth::user();

    	if($user->user_type =='administrator') {

    		if( $request->search) {

    		$accomplishment = $this->model->Where('date',$request->search);
    		} 

    	if( $request->search == null) {

            return redirect('/accomplishment');
        }

    	} else {

    		if( $request->search) {

    		$accomplishment = $this->model->Where('date',$request->search)->where('user_id', $user->id);

    		}

    		if( $request->search == null) {

            return redirect('/accomplishment');
       	 	}
    	}


    	$accomplishment = $accomplishment->paginate(30);
        return view('Accomplishment.index',compact('date','user','accomplishment'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    			'division'  =>  'sometimes|required',
                'date'  =>  'required',
                'natur_accomp'  =>  'required',
                'accomplishment'  =>  'required',
            ]);

    	if($request->division != null)
    	{
    		$user = User::where('id', $request->id)->first();

    		$user->division = $request->division;
    		$user->update();
    	}

    		$data['date'] = $request->date;
    		$data['natur_accomp'] = $request->natur_accomp;
    		$data['accomplishment'] = $request->accomplishment;
    		$data['quantity'] = $request->quantity;
    		$data['user_id'] = $request->id;
        	
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
