<?php

namespace App\Http\Controllers;

use App\Member;
use App\User;
use App\Meeting;
use App\Committee;
use Validator;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function __construct(Committee $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$user = User::get();

        return view('committe.index',compact('user'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'name' => 'required',
                'eo_number'  =>  'required',
                'date'  =>  'required',
                'time'  =>  'required',
                'venue' => 'required',
                'particulars' => 'required',
                'user_id'  =>  'required'
            ]);


    	$data['name'] = $request->name;
    	$data['eo_number'] = $request->eo_number;

    	$committe = $this->model->create($data);

    	$datas['date'] = $request->date;
    	$datas['time'] = $request->time;
    	$datas['venue'] = $request->venue;
    	$datas['particular'] = $request->particulars;
    	$datas['status'] = "Pending";
    	$datas['committee_id'] = $committe->id;

    	$meetings = Meeting::create($datas);


        $rules = [];
        foreach ($request->user_id as $key => $value) {
            $rules["user_id.{$key}"] = ['required'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            foreach ($request->user_id as $key => $value) {
                Member::create(['committee_id'=>$committe->id,'user_id'=>$value]);
            }
            
        }
           
    }
}
