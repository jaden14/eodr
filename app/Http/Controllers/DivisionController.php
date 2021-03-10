<?php

namespace App\Http\Controllers;

use App\Division;
use App\Office;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function __construct(Division $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$office = Office::orderBy('name','asc')->get();
    	$division = $this->model->with('office')->orderBy('office_id','asc')->paginate(20);
    	
        return view('division.index',compact('office','division'));
    }

    public function division_search(Request $request)
    {
    	$office = Office::orderBy('name','asc')->get();
    	$search = $request->get('division_search');

    	if( $search) {

    		$division = $this->model->Where('name',$request->division_search)->orWhereHas('office', function ($q) use ($search) {
                    return $q->where('name',$search);
                });
    		
    	} 

    	if( $search == null) {

    		 return redirect('/division');
    	}

    	$division = $division->paginate(20);

        return view('division.index',compact('office','division'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    			'office_id' => 'required',
                'name'  =>  'required',
            ]);

    	return $this->model->create($request->all());
    }

    public function division_edit(Request $request) 
    {

        return $this->model->where('id', $request->id)->first();
    }

    public function division_update(Request $request) 
    {
        $request->validate([
        		'office_id' => 'required',
                'name'  =>  'required',
            ]);

        $division = $this->model->where('id', $request->id)->first();

        $division->update($request->all());

        return $division;
    }

    public function division_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
