<?php

namespace App\Http\Controllers;

use App\Target;
use App\Output;
use Illuminate\Http\Request;
use App\Accomplishment;
use DB;
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

        $targeted = Target::first();

        $output = Output::select(DB::raw('count(period_from) as counted, period_to, period_from, target_id, user_id'))->with('target')->where('user_id', $user->id)->groupBy('period_from','period_to','target_id')->orderBy('period_from','desc')->paginate(30);

    	$target = $this->model->with([
    'accomplishment' => function ($query) use ($targeted) {
        $query->whereBetween('date', [$targeted->period_from, $targeted->period_to])->where('user_id', auth::user()->id);
    }])->where('position', $user->FPOSITION)->where('office_id', $user->office_id)->get();


        $accomplishment = Accomplishment::where('user_id', $user->id)->get();
       
        return view('target.index',compact('target','user','accomplishment','targeted','output'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'period_from'  =>  'required',
    			'period_to'  =>  'required',
                'code'  =>  'required',
                'indicator'  =>  'required',
                'qty'  =>  'required',
                'position' => 'required',
            ]);

    		$data['period_from'] = $request->period_from;
    		$data['period_to'] = $request->period_to;
    		$data['code'] = $request->code;
            $data['indicator'] = $request->indicator;
    		$data['qty'] = $request->qty;
            $data['office_id'] = Auth::user()->office_id;
    		$data['position'] = $request->position;


    		$target = $this->model->create($data);

    		return $target;
    }

    public function target_edit(Request $request) 
    {

        return $this->model->where('id', $request->id)->first();
    }

    public function target_update(Request $request) 
    {
        $request->validate([
                'period_from'  =>  'required',
                'period_to'  =>  'required',
                'code'  =>  'required',
                'indicator'  =>  'required',
                'qty'  =>  'required',
                'position' => 'required',
            ]);

        $target = $this->model->where('id', $request->id)->first();

        $target->period_from = $request->period_from;
        $target->period_to = $request->period_to;
        $target->code = $request->code;
        $target->indicator = $request->indicator;
        $target->qty = $request->qty;
        $target->office_id = auth::user()->office_id;
        $target->position = $request->position;
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
