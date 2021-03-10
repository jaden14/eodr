<?php

namespace App\Http\Controllers;

use App\Office;
use Illuminate\Http\Request;
use Auth;

class OfficeController extends Controller
{
    public function __construct(Office $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
        $office = $this->model->orderBy('name','asc')->paginate(20);
    	
        return view('office.index',compact('office'));
    }

    public function office_search(Request $request)
    {
    	if( $request->office_search) {

    		$office = $this->model->Where('name',$request->office_search);
    		
    	} 

    	if( $request->office_search == null) {

    		 return redirect('/offices');
    	}

    	$office = $office->paginate(20);

        return view('office.index',compact('office'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'name'  =>  'required',
            ]);

    	return $this->model->create($request->all());
    }

    public function office_edit(Request $request) 
    {

        return $this->model->where('id', $request->id)->first();
    }

    public function office_update(Request $request) 
    {
        $request->validate([
                'name'  =>  'required|unique:offices,name,'.$request->id,
            ]);

        $office = $this->model->where('id', $request->id)->first();

        $office->update($request->all());

        return $office;
    }

     public function office_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
