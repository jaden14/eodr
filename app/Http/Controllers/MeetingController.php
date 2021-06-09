<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Committee;
use App\Meeting;
use App\User;
use auth;

class MeetingController extends Controller
{
    public function __construct(Meeting $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$user = User::get();

    	$meeting = $this->model->with('committee.member.user')->where('user_id', auth::user()->id)->orWhereHas('committee.member', function ($q) use ($user) {
                    return $q->where('user_id',auth::user()->id);
                })->latest()->paginate(5);

    	$committee = Committee::latest()->get();

        return view('meeting.index',compact('user','meeting','committee'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'committee_name'  =>  'required',
    			'date'  =>  'required',
                'time'  =>  'required',
                'venue'  =>  'required',
                'particular'  =>  'required',
                'status'  =>  'required',
            ]);

    	$meet['committee_id'] = $request->committee_name;
    	$meet['date'] = $request->date;
    	$meet['time'] = $request->time;
    	$meet['venue'] = $request->venue;
    	$meet['particular'] = $request->particular;
    	$meet['status'] = $request->status;
    	$meet['user_id'] = $request->user_id;

    	$meeting =$this->model->create($meet);

    	return $meeting;
    }

     public function meeting_edit(Request $request) 
    {

        return $this->model->where('id', $request->id)->first();
    }

    public function meeting_update(Request $request)
    {
        $request->validate([
                'committee_name'  =>  'required',
    			'date'  =>  'required',
                'time'  =>  'required',
                'venue'  =>  'required',
                'particular'  =>  'required',
                'status'  =>  'required',
            ]);

        $meeting = $this->model->where('id', $request->id)->first();

        $meeting->committee_id = $request->committee_name;
        $meeting->date = $request->date;
        $meeting->time = $request->time;
        $meeting->venue = $request->venue;
        $meeting->particular = $request->particular;
        $meeting->status = $request->status;
        $meeting->update();
        
        return $meeting;  
    }

    public function meeting_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();

        $data->delete();

        return $data;
    }
}
