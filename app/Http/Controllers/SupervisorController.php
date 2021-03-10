<?php

namespace App\Http\Controllers;

use App\Division;
use App\Accomplishment;
use App\User;
use App\Office;
use Illuminate\Http\Request;
Use Carbon\Carbon;
use Auth;

class SupervisorController extends Controller
{
    public function __construct(Accomplishment $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
 	
        return view('supervisor.index');
    }
}
