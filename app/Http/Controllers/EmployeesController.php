<?php

namespace App\Http\Controllers;

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
}
