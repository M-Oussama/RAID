<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employees;
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
        $employees = Employees::all();
        return view('dashboard.contract.create')->with('employees',$employees);
    }

    public function store(Request $request){
        $contract = new Contract();

        $contract->employee_id = $request->employee_id;
        $contract->post = $request->post;
        $contract->post_location = $request->post_location;
        $contract->recruitment_date = $request->recruitment_date;
        $contract->insurance_date = $request->insurance_date;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;

        $contract->save();

        return redirect("/dash/contracts");
    }
}
