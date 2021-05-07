<?php

namespace App\Exports;


use App\User;
use App\Accomplishment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Auth;


class AccomplismentExport implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $date;

    function __construct($date) {
        $this->date = $date;
    }

    public function collection()
    {
    	$user = Auth::user()->office_id;
        
        $accomplishment = Accomplishment::with('user','user.division')->WhereHas('user', function ($q) use ($user) {
                    return $q->where('office_id',$user);
                })->whereMonth('date', date('m', strtotime($this->date)))->whereYear('date', $this->date)->orderBy('user_id','asc')->orderBy('date','desc')->get();

        return $accomplishment;
    }

    public function headings(): array
    {
    	return [
    		'Date',
    		'Nature of Accomplishment',
    		'Cats No.',
    		'Name',
    		'Division',
    		'Accomplishment',
    		'Quantity'
    	];
    }
    public function map($accomplishment): array
    {
    	return [
    		$accomplishment->date,
    		$accomplishment->natur_accomp,
    		$accomplishment->user->cats,
    		$accomplishment->user->FLAST.', '.$accomplishment->user->FFIRST.' '.$accomplishment->user->FMI,
    		$accomplishment->user->division->name,
    		$accomplishment->accomplishment,
    		$accomplishment->quantity
    	];
    }
}
