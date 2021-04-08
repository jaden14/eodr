<?php

namespace App\Http\Controllers;

use App\Accomplishment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccomplismentExport;

class ExportController extends Controller
{
    public function __construct(Accomplishment $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('export.index');
    }

    public function export() 
	{
        return Excel::download(new AccomplismentExport, 'Accomplishment.xlsx');
	}
}
