<?php

namespace App\Http\Controllers;

use App\Member;
use App\User;
use App\Meeting;
use App\Committee;
use Validator;
use Illuminate\Http\Request;
use auth;

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

        $committe = $this->model->with('member.user')->latest()->paginate(5);

        return view('committe.index',compact('user','committe'));
    }

    public function committe_add(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'eo_number'  =>  'required',
                'chairperson'  =>  'required',
                'cochair'  =>  'required',
                'user_id' => 'required',
            ]);


        $data['name'] = $request->name;
        $data['eo_number'] = $request->eo_number;

        $committe = $this->model->create($data);

       
        $chairpersons = Member::create(['committee_id' => $committe->id,
                        'user_id' => $request->chairperson,
                        'position' => 'Chairperson']);
        

        $cochairs = Member::create(['committee_id' => $committe->id,
                        'user_id' => $request->cochair,
                        'position' => 'Co-Chair']);
        

        $rules = [];
        foreach ($request->user_id as $key => $value) {
            $rules["user_id.{$key}"] = ['required'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            foreach ($request->user_id as $key => $value) {
                Member::create(['committee_id'=>$committe->id,'user_id'=>$value,'position' =>'Member']);
            }
            
        }
           
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
        $datas['user_id'] = auth::user()->id;

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

    public function committe_edit(Request $request) 
    {

        return $this->model->with('member','meeting')->where('id', $request->id)->first();
    }

    public function committe_editperson(Request $request) 
    {

        return Member::with('user')->where('id', $request->id)->first();
    }

    public function committe_updateperson(Request $request)
    {
        $request->validate([
                'user_id' => 'required',
            ]);

        $member = Member::where('id', $request->id)->first();

        $member->user_id = $request->user_id;
        $member->update();
        
        return $member;  
    }

    public function committe_update(Request $request)
    {
        $request->validate([
                'eo_number'  =>  'required',
                'name' => 'required',
            ]);

        $committe = $this->model->where('id', $request->id)->first();

        $committe->name = $request->name;
        $committe->eo_number = $request->eo_number;
        $committe->update();

        if ($request->user_id != null) {
            foreach ($request->user_id as $key => $value) {
                Member::create(['committee_id'=>$request->id,'user_id'=>$value, 'position' => 'Member']);
            }
            
        }
        
        return $committe;  
    }

    public function committe_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();

        $member = Member::where('committee_id', $request->id)->delete();
        
        $data->delete();

        return $data;
    }

    public function member_delete(Request $request) 
    {
        $data = Member::where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
