<?php

namespace App\Http\Controllers;

use App\Member;
use App\User;
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

        $rules = [];
        foreach ($request->user_id as $key => $value) {
            $rules["user_id.{$key}"] = ['required'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            foreach ($request->user_id as $key => $value) {
                Member::create(['committee_id'=>$value,'user_id'=>$value]);
            }
            
        }
           
    }
}
