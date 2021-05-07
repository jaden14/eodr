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

        $committe = $this->model->with('member.user.office','meeting')->WhereHas('meeting', function ($q) use ($user) {
                    return $q->where('user_id',auth::user()->id);
                })->orWhereHas('member', function ($q) use ($user) {
                    return $q->where('user_id',auth::user()->id);
                })->latest()->paginate(3);

        return view('committe.index',compact('user','committe'));
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

    public function committe_update(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'eo_number'  =>  'required',
                'date'  =>  'required',
                'time'  =>  'required',
                'venue' => 'required',
                'particulars' => 'required',
            ]);

        $committe = $this->model->where('id', $request->id)->first();

        $meeting = Meeting::where('committee_id', $request->id)->first();

        $committe->name = $request->name;
        $committe->eo_number = $request->eo_number;
        $committe->update();

        $meeting->date = $request->date;
        $meeting->time = $request->time;
        $meeting->venue = $request->venue;
        $meeting->particular = $request->particulars;
        $meeting->status = $request->status;
        $meeting->update();

        if ($request->user_id != null) {
            foreach ($request->user_id as $key => $value) {
                Member::create(['committee_id'=>$request->id,'user_id'=>$value]);
            }
            
        }
        
        return $committe;  
    }

    public function committe_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();

        $member = Member::where('committee_id', $request->id)->first();

        $meeting = Meeting::where('committee_id', $request->id)->first();

        $meeting->delete();

        $member->delete();
        
        $data->delete();

        return $data;
    }

    public function member_delete(Request $request) 
    {
        $data = Member::where('user_id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
