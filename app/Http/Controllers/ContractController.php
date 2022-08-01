<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employees;
use App\Models\Paper;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $contracts = Contract::all();
        return view('dashboard.contract.index')->with('contracts',$contracts);
    }

    public function create()
    {
        $employees = Employees::whereIN('id',function ($query){
            $query->select('employee_id')->from(with (new Contract)->getTable())->where('end_date','<',date('Y-m-d'))->pluck('employee_id')->toArray();
        })->get();
        return view('dashboard.contract.create')->with('employees',$employees);
    }

    public function createChiefContract(){

        $contract = Contract::all();

        if(count($contract) > 0)
            $employees = Employees::whereIN('id',function ($query){
                $query->select('employee_id')->from(with (new Contract)->getTable())->where('end_date','<',date('Y-m-d'))->pluck('employee_id')->toArray();
            })->get();
        else
            $employees = Employees::all();

        return view('dashboard.contract.create')->with('employees',$employees);
    }


    public function store(Request $request){

        $start_date = date($request->start_date);

        if($request->contract_length == "1"){
            // 1 year
            $end_date = date("Y-m-d",strtotime("+12 months",strtotime($start_date)));
            $contract_length = 1;
        }else{
            // 6 months
            $end_date = date("Y-m-d",strtotime("+6 months",strtotime($start_date)));
            $contract_length = 2;
        }

        $contract = new Contract();
        $contract->employee_id = $request->employee_id;
        $contract->post = $request->post;
        $contract->post_location = $request->post_location;
        $contract->recruitment_date = $request->recruitment_date;
        $contract->insurance_date = $request->insurance_date;
        $contract->contract_length = $contract_length;
        $contract->start_date = $request->start_date;
        $contract->end_date = $end_date;

        $contract->save();

        $paper = new Paper();
        //$paper->paper_type = "contract";
        $paper->employee_id = $request->employee_id;
        $paper->date = date('Y-m-d');
        $paper->save();
        return redirect("/dash/contracts");
    }
}
