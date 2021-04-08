<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;
Use Carbon\Carbon;
use App\User;
use Auth;

class JournalController extends Controller
{
    public function __construct(Journal $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$date = Carbon::now();
    	$user = auth::user();
    	$users = User::where('office_id', $user->office_id)->get();

        $journal = $this->model->with('user')->where('user_id', $user->id)->latest()->paginate(30);

    	return view('journal.index',compact('journal','user','date','users'));
    }

    public function searchsss(Request $request)
    {
    	$date = Carbon::now();
    	$user = auth::user();
    	$users = User::where('office_id', $user->office_id)->get();
    	
    	if( $request->search && $request->search2) {

    		$journal = $this->model->Wherebetween('date',[$request->search, $request->search2])->where('user_id', $user->id);

    		}

    		if( $request->search == null || $request->search2 == null) {

            return redirect('/journal');
       	 	}

    	$journal = $journal->paginate(30);
        return view('journal.index',compact('date','user','journal','users'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'date'  =>  'required',
                'time'  =>  'required',
                'whereto'  =>  'required',
            ]);

    		$data['date'] = $request->date;
    		$data['time'] = $request->time;
    		$data['whereto'] = $request->whereto;
    		$data['user_id'] = $request->id;
        	
        	$journal = $this->model->create($data);

    		return $journal;
    }

    public function journal_edit(Request $request) 
    {

        return $this->model->where('id', $request->id)->first();
    }

    public function journal_update(Request $request) 
    {
        $request->validate([
                'date'  =>  'required',
                'time'  =>  'required',
                'whereto'  =>  'required',
            ]);

        $journal = $this->model->where('id', $request->id)->first();

        $journal->update($request->all());

        return $journal;
    }

    public function journal_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
