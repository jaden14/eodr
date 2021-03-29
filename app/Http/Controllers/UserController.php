<?php

namespace App\Http\Controllers;

use Auth;
use App\Division;
use App\User;
use App\Office;
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

    	$office = Office::orderBy('name','asc')->get();
        $user = auth::user();

        if($user->user_type =='Supervisor') {

    	$user = $this->model->with('division')->where('office_id', $user->office_id)->latest()->paginate(30);

        } else {
            $user = $this->model->with('division')->latest()->paginate(30);
        }

        return view('user.index', compact('user','office'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);

        return view('user.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find(auth()->user()->id);
        $validate = $request->validate([
           'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (Hash::check($request->current_password, $user->password) && $request->password == $request->password_confirmation) {
            $user->password = bcrypt($request->password);
            $user->update();

            return back()->with('success', 'Password Changed');
        } else {
            return back()->with('delete', 'Current Password Not match!!');
        }
    }

    public function employees_division(Request $request)
    {
    
        //if our chosen id and products table prod_cat_id col match the get first 100 data 

        //$request->id here is the id of our chosen option id
        $data=Division::select('name','id')->where('office_id',$request->id)->orderBy('name','asc')->get();

        return response()->json($data);//then sent this data to ajax success
    }

    public function search(Request $request)
    {
        $office = Office::orderBy('name','asc')->get();
        $user = auth::user();

    	if( $request->search) {

            if($user->user_type =='Supervisor') {

    		$user = $this->model->where('office_id', $user->office_id)
                                ->Where('cats', 'like', '%' . $request->search . '%');
    												
            } else {
                $user = $this->model->Where('cats', 'like', '%' . $request->search . '%');

            }
    	}


        if( $request->search == null) {

            return redirect('/employees');
        }

    	$user = $user->paginate(30);
        return view('user.index',compact('user','office'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'cats'  =>  'required|unique:users|digits:4',
                'FLAST'  =>  'required',
                'FFIRST'  =>  'required',
                'FMI'  =>  'required',
                'office_id' => 'required',
                'division_id'  =>  'required',
                'user_type' => 'required',
                'password'  =>  'required',
            ]);

    		$request['password'] = Hash::make($request->password);

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
                'office_id' => 'required',
                'division_id'  =>  'required',
                'user_type' => 'required',
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
