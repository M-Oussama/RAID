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
        $contracts = Contract::orderby('created_at','desc')->get();
        return view('dashboard.contract.index')->with('contracts',$contracts);
    }

    public function create()
    {
        $employees = Employees::whereNotIN('id',function ($query){
            $query->select('employee_id')->from(with (new Contract)->getTable())->where('cancel',0)->where('end_date','>=',date('Y-m-d'))
                ->pluck('employee_id')->toArray();
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

        return view('dashboard.contract.createChief')->with('employees',$employees);
    }


    public function extendContract(Request $request,$id){

        $contract = Contract::find($id);
        $contract->extension = false;
        $contract->save();
        $request->employee_id = $contract->employee_id;
        $start_date = date($request->start_date);
        $end_date = date($request->end_date);



        $contract = new Contract();
        $contract->employee_id = $request->employee_id;
        $contract->post = $request->post;
        $contract->post_location = $request->post_location;
        $contract->salary = $request->salary;
        $contract->recruitment_date = $request->recruitment_date;
        $contract->insurance_date = $request->insurance_date;
        $contract->contract_length = $request->contract_length;
        $contract->start_date = $start_date;
        $contract->end_date = $end_date;
        //$contract->exp_end_date = date($request->exp_end_date);

        $contract->save();

        $paper = new Paper();
        $paper->paper_type_id = $request->paper_type_id;
        $paper->contract_id = $contract->id;
        $paper->employee_id = $request->employee_id;
        $paper->date = date('Y-m-d');
        $paper->save();
        return redirect("/dash/contracts");

    }

    public function store(Request $request){


        $start_date = date($request->start_date);
        $end_date = date($request->end_date);

   /*     if($request->contract_length == "1"){
            // 1 year
            $end_date = $request->end_date;
            $contract_length = 1;
        }else{
            // 6 months
            $end_date = date("Y-m-d",strtotime("+6 months",strtotime($start_date)));
            $contract_length = 2;
        }*/

        $contract = new Contract();
        $contract->employee_id = $request->employee_id;
        $contract->post = $request->post;
        $contract->post_location = $request->post_location;
        $contract->salary = $request->salary;
        $contract->recruitment_date = $request->recruitment_date;
        $contract->insurance_date = $request->insurance_date;
        $contract->contract_length = $request->contract_length;

        $contract->exp_contract_length = $request->exp_contract_length;
        $contract->start_date = $start_date;
        $contract->end_date = $end_date;
        $contract->exp_end_date = date($request->exp_end_date);

        $contract->save();

        $paper = new Paper();
        $paper->paper_type_id =$request->paper_type_id;
        $paper->contract_id = $contract->id;
        $paper->employee_id = $request->employee_id;
        $paper->date = date('Y-m-d');
        $paper->save();
        return redirect("/dash/contracts");
    }

    public function destroy($id){
        $contract = Contract::find($id);
        $paper = Paper::where('contract_id',$id)->get();
        $paper->delete();
        $contract->delete();

        session()->flash('type', "success");
        session()->flash('message', "تمت عملية حذف العقد بنجاح");

        return redirect()->back();
    }

    public function cancelContract($id){
        $contract = Contract::find($id);

        $paper = new Paper();
        $paper->paper_type_id = 13;
        $paper->employee_id = $contract->employee_id;
        $paper->contract_id =  $contract->contract_id;
        $paper->save();

        $contract->paper_id = $paper->id;
        $contract->cancel = true;
        $contract->save();


        session()->flash('type', "success");
        session()->flash('message', "تمت عملية الغاء العقد بنجاح");

        return redirect()->back();
    }
}
