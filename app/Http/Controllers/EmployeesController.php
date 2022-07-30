<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Baladia;
use App\Models\Daira;
use App\Models\Employees;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $employees = Employees::all();
        return view('dashboard.people.employees.index')->with('employees',$employees);
    }


    public function create()
    {
        $wilayas = Wilaya::all();

        $baladias = Baladia::whereIn('daira_id',function ($query) use ($wilayas){
            $query->select('id')->from(with(new Daira)->getTable())->where('wilaya_id',$wilayas->first()->id)->pluck('id')->toArray();
        })->get();

        return view('dashboard.people.employees.create')->with('wilayas',$wilayas)->with('baladias',$baladias);
    }

    public function store(Request $request){

        $birthdplace = new Address();
        $birthdplace->address = $request->birthplace;
        $birthdplace->wilaya_id = $request->wilaya_id;
        $birthdplace->save();

        $employee = new Employees();

        $employee->name = $request->name;
        $employee->surname = $request->surname;
        $employee->birthdate = $request->birthdate;
        $employee->birthplace_id = $birthdplace->id;
        $employee->family_status = $request->family_status;
        $employee->children_number = $request->children_number;
        $employee->wife_name = $request->wife_name;
        $employee->birthday_document_number = $request->birthday_document_number;
        $employee->education_level = $request->education_level;
        $employee->blood_type = $request->blood_type;
        $employee->postal_account_number = $request->postal_account_number;
        $employee->social_security_number = $request->social_security_number;
        $employee->recruitment_date = $request->recruitment_date;
        $employee->insurance_date = $request->insurance_date;
        $employee->national_service = $request->national_service;
        $employee->national_service_rank = $request->national_service_rank;
        $employee->phone = $request->phone;

        if($request->document_type == "NC")
            $employee->national_card = true;
        else
            $employee->driver_license = false;

        $document_address = new Address();
        $document_address->address = $request->document_address;
        $document_address->wilaya_id = $request->document_wilaya;
        $document_address->baladia_id =$request->document_baladia;
        $document_address->save();

        $employee->document_address = $document_address->id;
        $employee->document_date = $request->document_date;
        $employee->document_number = $request->document_number;

        $employee->save();

        return redirect("/dash/security/assistance");


    }
}
