<?php

namespace App\Http\Controllers;

use App\Division;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(User $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$division = Division::orderBy('name','asc')->get();
    	$user = $this->model->with('division')->latest()->paginate(30);

        return view('user.index', compact('user','division'));
    }

    public function search(Request $request)
    {
        $division = Division::orderBy('name','asc')->get();
    	if( $request->search) {

    		$user = $this->model->Where('cats', 'like', '%' . $request->search . '%')
    							->OrWhere('FLAST', 'like', '%' . $request->search . '%')
    							->OrWhere('FFIRST', 'like', '%' . $request->search . '%')
    							->OrWhere('FMI', 'like', '%' . $request->search . '%');
    	}


        if( $request->search == null) {

            return redirect('/employees');
        }

    	$user = $user->paginate(30);
        return view('user.index',compact('user','division'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'cats'  =>  'required|unique:users|digits:4',
                'FLAST'  =>  'required',
                'FFIRST'  =>  'required',
                'FMI'  =>  'required',
                'division_id'  =>  'required',
            ]);

    		$request['password'] = Hash::make('1');

    	return $this->model->create($request->all());
    }

    public function user_edit(Request $request) 
    {

        return $this->model->with('division')->where('id', $request->id)->first();
    }

    public function user_update(Request $request) 
    {
        $request->validate([
                'cats'  =>  'required|unique:users,cats,'.$request->id,
                'FLAST'  =>  'required',
                'FFIRST'  =>  'required',
                'FMI'  =>  'required',
                'division_id'  =>  'required',
            ]);

        $user = $this->model->where('id', $request->id)->first();

        $user->update($request->all());

        return $user;
    }

    public function user_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
