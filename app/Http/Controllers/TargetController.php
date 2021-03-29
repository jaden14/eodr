<?php

namespace App\Http\Controllers;

use App\Target;
use App\Output;
use Illuminate\Http\Request;
use Auth;

class TargetController extends Controller
{
    public function __construct(Target $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$user = auth::user();
    	$target = $this->model->with('user','output','accomplishment')->where('user_id', $user->id)->get();

        return view('target.index',compact('target','user'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'period_from'  =>  'required',
    			'period_to'  =>  'required',
                'code'  =>  'required',
                'indicator'  =>  'required',
                'qty'  =>  'required',
            ]);

    		$output['indicator'] = $request->indicator;

    		$output = Output::create($output);

    		$data['period_from'] = $request->period_from;
    		$data['period_to'] = $request->period_to;
    		$data['code'] = $request->code;
    		$data['output_id'] = $output->id;
    		$data['qty'] = $request->qty;
    		$data['user_id'] = $request->user_id;


    		$target = $this->model->create($data);

    		return $target;
    }

    public function target_edit(Request $request) 
    {

        return $this->model->with('output')->where('id', $request->id)->first();
    }

    public function target_update(Request $request) 
    {
        $request->validate([
                'period_from'  =>  'required',
                'period_to'  =>  'required',
                'code'  =>  'required',
                'indicator'  =>  'required',
                'qty'  =>  'required',
            ]);

        $output = Output::where('id', $request->output_id)->first();

        $output->indicator = $request->indicator;
        $output->update();

        $target = $this->model->where('id', $request->id)->first();

        $target->period_from = $request->period_from;
        $target->period_to = $request->period_to;
        $target->code = $request->code;
        $target->qty = $request->qty;
        $target->update();

        return $target;
    }

    public function target_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
