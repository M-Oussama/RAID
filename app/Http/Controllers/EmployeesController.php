<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\Address;
use App\Models\Baladia;
use App\Models\Contract;
use App\Models\Daira;
use App\Models\Employees;
use App\Models\Paper;
use App\Models\User;
use App\Models\Wilaya;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
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

        $dairas = Daira::where('wilaya_id',$wilayas->first()->id)->get();

        $baladias = Baladia::whereIn('daira_id',function ($query) use ($wilayas){
            $query->select('id')->from(with(new Daira)->getTable())->where('wilaya_id',$wilayas->first()->id)->pluck('id')->toArray();
        })->get();

        return view('dashboard.people.employees.create')->with('wilayas',$wilayas)->with('baladias',$baladias)->with('dairas',$dairas);
    }

    public function store(Request $request){

        $birthdplace = new Address();
        $birthdplace->address = $request->birthplace;
        $birthdplace->wilaya_id = $request->wilaya_id;
        $birthdplace->baladia_id = $request->baladia_id;
        $birthdplace->daira_id = $request->daira_id;
        $birthdplace->save();

        $living_address = new Address();
        $living_address->address = $request->address;
        $living_address->wilaya_id = $request->wilaya_address;
        $living_address->save();

        $document_address = new Address();
        $document_address->address = $request->document_address;
        $document_address->wilaya_id = $request->document_wilaya;
        $document_address->daira_id = $request->document_daira;
        $document_address->baladia_id =$request->document_baladia;
        $document_address->save();

        $employee = new Employees();

        $employee->name = $request->name;
        $employee->surname = $request->surname;
        $employee->birthdate = $request->birthdate;
        $employee->birthplace_id = $birthdplace->id;
        $employee->family_status = $request->family_status;
        $employee->children_number = $request->children_number;
        $employee->wife_name = $request->wife_name;
        $employee->address_id = $living_address->id;
        $employee->birthday_document_number = $request->birthday_document_number;
        $employee->father_name = $request->father_name;
        $employee->mother_fullname = $request->mother_fullname;
        $employee->education_level = $request->education_level;
        $employee->blood_type = $request->blood_type;
        $employee->postal_account_number = $request->postal_account_number;
        $employee->social_security_number = $request->social_security_number;
        $employee->recruitment_date = $request->recruitment_date;
        $employee->insurance_date = $request->insurance_date;
        $employee->national_service = $request->national_service;
        $employee->national_service_rank = $request->national_service_rank;
        $employee->phone = $request->phone;

        if($request->document_type == "NC"){
            $employee->national_card = true;
            $employee->document_number = $request->document_number1;
        }
        else{
            $employee->driver_license = true;
            $employee->document_number = $request->document_number2;
        }


        $employee->document_address = $document_address->id;
        $employee->document_date = $request->document_date;

        $employee->save();

        if (!empty($request->avatar)) {
            $employee->addMediaFromRequest('avatar')
                ->toMediaCollection('avatars');
        }


        $employee_id = "";
        if($employee->id < 10){
            $employee_id = str_pad($employee->id, 3, '0', STR_PAD_LEFT);
        }

        if($employee->id <100 && $employee->id >= 10){
            $employee_id = str_pad($employee->id, 2, '0', STR_PAD_LEFT);
        }
        $wilaya_id =$request->wilaya_id;

        if($request->wilaya_id < 10){
            $wilaya_id = str_pad($request->wilaya_id, 2, '0', STR_PAD_LEFT);
        }
        $matricule = "MATR.".date('m',strtotime($request->recruitment_date))."/".substr( date("Y",strtotime($request->recruitment_date)), -2)."/".$wilaya_id."/".$employee_id;

        $employee->MATRICULE = $matricule;
        $employee->save();

        session()->flash('type', "success");
        session()->flash('message', "تمت اضافة الموظف بنجاح");
        return redirect("/dash/security/assistance");


    }

    public function edit($id)
    {

        $employee = Employees::find($id);
        $wilayas = Wilaya::all();

        $dairas = Daira::where('wilaya_id',$employee->address->wilaya_id)->get();

        $baladias = Baladia::whereIn('daira_id',function ($query) use ($employee){
            $query->select('id')->from(with(new Daira)->getTable())->where('wilaya_id',$employee->address->wilaya_id)->pluck('id')->toArray();
        })->get();

        return view('dashboard.people.employees.edit')
            ->with('employee',$employee)
            ->with('wilayas',$wilayas)
            ->with('baladias',$baladias)
            ->with('dairas',$dairas);
    }

    public function update(Request $request,$id){



        $employee = Employees::find($id);

        $birthdplace = Address::find($employee->birthplace_id);
        $birthdplace->address = $request->birthplace;
        $birthdplace->wilaya_id = $request->wilaya_id;
        $birthdplace->baladia_id = $request->baladia_id;
        $birthdplace->daira_id = $request->daira_id;
        $birthdplace->save();

        $living_address = Address::find($employee->address_id);
        $living_address->address = $request->address;
        $living_address->wilaya_id = $request->wilaya_address;
        $living_address->save();

        $document_address = Address::find($employee->document_address);
        $document_address->address = $request->document_address;
        $document_address->wilaya_id = $request->document_wilaya;
        $document_address->daira_id = $request->document_daira;
        $document_address->baladia_id =$request->document_baladia;
        $document_address->save();

        $employee->name = $request->name;
        $employee->surname = $request->surname;
        $employee->birthdate = $request->birthdate;

        $employee->family_status = $request->family_status;
        $employee->children_number = $request->children_number;
        $employee->wife_name = $request->wife_name;

        $employee->birthday_document_number = $request->birthday_document_number;
        $employee->father_name = $request->father_name;
        $employee->mother_fullname = $request->mother_fullname;
        $employee->education_level = $request->education_level;
        $employee->blood_type = $request->blood_type;
        $employee->postal_account_number = $request->postal_account_number;
        $employee->social_security_number = $request->social_security_number;
        $employee->recruitment_date = $request->recruitment_date;
        $employee->insurance_date = $request->insurance_date;
        $employee->national_service = $request->national_service;
        $employee->national_service_rank = $request->national_service_rank;
        $employee->phone = $request->phone;

        if($request->document_type == "NC"){
            $employee->national_card = true;
            $employee->driver_license = false;
            $employee->document_number = $request->document_number1;
        }
        else{
            $employee->driver_license = true;
            $employee->national_card = false;

            $employee->document_number = $request->document_number2;
        }

        $employee->document_date = $request->document_date;



        $employee->save();

        if (!empty($request->avatar)) {
            if (!empty($employee->getFirstMedia('avatars'))) {
                $employee->getFirstMedia('avatars')->delete();
            }
            $employee->addMediaFromRequest('avatar')
                ->toMediaCollection('avatars');
        }

        if (!empty($request->avatar_remove)){
            $employee->getFirstMedia('avatars')->delete();
        }


        session()->flash('type', "success");
        session()->flash('message', "تم تعديل معلومات الموظف بنجاح");
        return redirect("/dash/security/assistance");
    }
    public function destroy($id){
        $employee = Employees::find($id);
        $papers = Paper::where('employee_id',$id)->get();
        foreach($papers as $paper){
            $paper->delete();
        }
        $contracts = Contract::where('employee_id',$employee->id)->get();
            foreach($contracts as $contract){
                $contract->delete();
            }

        $employee->delete();
        session()->flash('type', "success");
        session()->flash('message', "تمت عملية حذف الموظف بنجاح");

        return redirect()->back();
    }


    public function deleteMulti(Request $request){
        $ids = $request->input('ids');
        foreach ($ids as $id){
            User::find($id)->delete();
        }
        session()->flash('type', 'success');
        session()->flash('message', 'تمت عملية حذف الموظفين بنجاح');
        return redirect()->back();
    }



    public function generatePdf(User $user){
        $data = [
            'user' => $user,
        ];
        $pdf = PDF::loadView('dashboard.people.users.pdf.pdf', $data);
        return $pdf->download($user->name.' '.$user->surname.' file.pdf');
    }
}
