<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employees;
use App\Models\Paper;
use App\Models\PaperType;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class PaperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {


        $papers_type = array(
            "عقد عمل رئيس موقع ورئيس فوج & محضر تنصب",
            "عقد عمل لعون الأمن & محضر تنصب",
            "محضر تقاضي المستحقات",
            "قرار تحويل",
            "شهادة عمل",
            "بطاقـــــة معلومــــات",
            "بطاقة فردية خاصة بالملابس",
            "العطلة",
            "إستفسار",
            "إستدعاء",
        );

        $papers = PaperType::where('active',true)->get();
            $counter = 1;
            foreach ($papers as $paper){
                $paper->index = $counter;
                $counter++;
            }


        $employees = Employees::all();
        $mutation_employees = Employees::whereIN('id',function ($query){
            $query->select('employee_id')->from(with (new Contract)->getTable())->where('end_date','>=',date('Y-m-d'))->pluck('employee_id')->toArray();
        })->get();

        $business_paper_employees = Employees::whereIN('id',function ($query){
            $query->select('employee_id')->from(with (new Contract)->getTable())->pluck('employee_id')->toArray();
        })->get();


        return view('dashboard.paper.index')
            ->with('papers',json_encode($papers))
            ->with('employees',$employees)->with('MEmployees',$mutation_employees)
            ->with('business_paper_employees',$business_paper_employees);
    }

    public function papersList()
    {
        $papers = Paper::orderby('created_at','desc')->get();

        return view('dashboard.paper.list_of_papers')->with('papers',$papers);
    }

    function arabize_date($date) {
        # دالة كتابة التاريخ بالكلمات العربية ||
        # برمجة علي س. النعيمي                ||
        # www.the-ghost.com                   ||
        //$day = number_format(substr($date,0,2),null,null,null);
        $day = (int)date('d', strtotime($date));
       // $month = number_format(substr($date,3,2),null,null,null);
        $month =  (int)date('m', strtotime($date));
        $year = date('Y', strtotime($date));
      //  $year = substr($date,6,4);

        $text = "";
        #اليوم
        $days_array = array("الصفر","الأول","الثاني","الثالث","الرابع","الخامس","السادس","السابع","الثامن","التاسع","العاشر","الحادي عشر","الثاني عشر","الثالث عشر","الرابع عشر","الخامس عشر","السادس عشر","السابع عشر","الثامن عشر","التاسع عشر","العشرين","الحادي و العشرين","الثاني و العشرين","الثالث و العشرين","الرابع و العشرين","الخامس و العشرين","السادس و العشرين","السابع و العشرين","الثامن و العشرين","التاسع و العشرين","الثلاثين","الحادي و الثلاثين","الثاني و الثلاثين","الثالث و الثلاثين");
        $text.= $days_array[$day];
        #الشهر
        $text.=' من شهر ';
        $months_array = array("جانفي","فيفري","مارس","أفريل","ماي","جوان","جويلية","أوت","سبتمبر","أكتوبر","نوفمبر","ديسمبر");
        $text.= $months_array[$month-1];
        #السنة
        $text.= ' عام '.$year;
        return $text;
    }
    public function exportContract($id){
        $contract = Contract::find($id);
        $paper = Paper::where('contract_id',$id)->get()->first();
        $contract->start_date_ar = $this->arabize_date($contract->start_date);


        return view('dashboard.paper.papers.contract')->with('contract',$contract)->with('paper',$paper);
    }

    public function exportPaper(Request $request,$id){


        switch ($id){
            case 1: {
                // عقد عمل رئيس موقع ورئيس فوج & محضر تنصب

                 return redirect("/dash/contracts/create");
            }

            case 2: {
                // عقد عمل لعون الأمن & محضر تنصب
                return redirect("/dash/contracts/create");
                break;
            }

            case 3: {
                // تمديد عقد رئيس موقع فوج

                $view = "";
                break;

            }
            case 4: {
                // تمديد عقد عون أمن

                $view = "";
                break;

            }
            case 5: {
                // محضر تقاضي المستحقات


                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $paper->save();


                return redirect("/dash/papers/list");

                break;
            }
            case 6: {
                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $paper->save();
                // قرار تحويل

                return redirect("/dash/papers/list");
                break;
            }
            case 7: {
                // شهادة عمل

                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $contract = Contract::where('employee_id',$request->employee_id)->get()->last();
                $paper->contract_id = $contract->id;
                $paper->save();
                return redirect("/dash/papers/list");

                break;
            }
            case 8: {
                // بطاقـــــة معلومــــات

                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $paper->save();

                return redirect("/dash/papers/list");
                //$view = "dashboard.paper.papers.information_card";
                break;
            }
            case 9: {
                // بطاقة فردية خاصة بالملابس

                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $paper->save();
                return redirect("/dash/papers/list");

                break;
            }
            case 10: {
                // العطلة
                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $paper->vacation_length = $request->employee_id;
                $paper->vacation_start = $request->vacation_start_date;
                $paper->save();
                return redirect("/dash/papers/list");
                break;
            }
            case 11: {
                // إستفسار
                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $paper->date = date('Y-m-d');
                $paper->save();
                return redirect("/dash/papers/list");
                break;
            }
            case 12: {
                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $paper->date = date('Y-m-d');
                $paper->save();
                return redirect("/dash/papers/list");
                break;
            }
            default: return redirect("/dash/papers");

        }


        return view($view);
    }

    public function export(Request $request,$paper_type_id,$id){


        $view = "";

        // $paper = new Paper();
        // $paper->paper_type = $request->paper_type;
        // $paper->employee_id = $request->employee_id;
        // $paper->save();



        switch ($paper_type_id){
            case 1: {
                // عقد عمل رئيس موقع ورئيس فوج & محضر تنصب

                return redirect("/dash/contracts/chief/create");
            }

            case 2: {
                // عقد عمل لعون الأمن & محضر تنصب
                return redirect("/dash/contracts/create");
                break;
            }

            case 3: {
                // تمديد عقد رئيس موقع فوج

                $view = "";
                break;

            }
            case 4: {
                // تمديد عقد عون أمن

                $view = "";
                break;

            }
            case 5: {
                // محضر تقاضي المستحقات
                $view = "dashboard.paper.papers.get_all_paiements";
                $paper = Paper::find($id);
                $contract = Contract::where('employee_id',$paper->employee_id)->where('cancel',0)->where('extension',1)->get()->first();

                return view($view)->with('paper',$paper)->with('contract',$contract);

                break;
            }
            case 6: {

                $paper = Paper::find($id);
                $contract = Contract::where('employee_id',$paper->employee_id)->get()->last();
                // قرار تحويل
                $view = "dashboard.paper.papers.mutation";
                return view($view)->with('paper',$paper)->with('contract',$contract);
                break;
            }
            case 7: {
                // شهادة عمل
                $view = "dashboard.paper.papers.business_certificate";

                $paper = Paper::find($id);
                $contract = Contract::where('employee_id',$paper->employee_id)->get()->last();
                return view($view)->with('paper',$paper)->with('contract',$contract);

                break;
            }
            case 8: {
                // بطاقـــــة معلومــــات
                $paper = Paper::find($id);
                $view = "dashboard.paper.papers.information_card";
                $contract = Contract::where('employee_id',$paper->employee_id)->get()->last();
                return view($view)->with('paper',$paper)->with('contract',$contract);

                break;
            }
            case 9: {
                // بطاقة فردية خاصة بالملابس
                $paper = Paper::find($id);
                $view = "dashboard.paper.papers.clothes_card";
                $contract = Contract::where('employee_id',$paper->employee_id)->get()->last();
                return view($view)->with('paper',$paper)->with('contract',$contract);

                break;
            }
            case 10: {
                // العطلة

                $paper = Paper::find($id);
                $contract = Contract::where('employee_id',$paper->employee_id)->get()->last();
                $view = "dashboard.paper.papers.vacation";
                return view($view)->with('paper',$paper)->with('contract',$contract);
                break;
            }
            case 11: {
                // إستفسار
                $paper = Paper::find($id);
                $view = "dashboard.paper.papers.inquiry";
                return view($view)->with('paper',$paper);

                break;
            }
            case 12: {
                // إستدعاء
                $paper = Paper::find($id);
                $contract = Contract::where('employee_id',$paper->employee_id)->get()->last();

                $view = "dashboard.paper.papers.call";
                return view($view)->with('paper',$paper)->with('contract',$contract);

                break;
            }
            default: return redirect("/dash/papers");

        }


        return view($view);
    }

    public function destroy($id){
        $paper = Paper::find($id);
        $paper->delete();

        session()->flash('type', "success");
        session()->flash('message', "تمت عملية حذف الوثيقة بنجاح");

        return redirect()->back();
    }

    public function exportCancelPDF($id){
        $paper = Paper::find($id);
        $contract = Contract::where('employee_id',$paper->employee_id)->get()->last();

        $view = "dashboard.paper.papers.contract_termination";
        return view($view)->with('paper',$paper)->with('contract',$contract);
    }

    public function exportPaiementPDF($id){
        $contract = Contract::find($id);
        $paper = new Paper();
        $paper->paper_type_id = $id;
        $paper->employee_id = $contract->employee_id;
        $paper->contract_id = $contract->id;
        $paper->save();

        $view = "dashboard.paper.papers.get_all_paiements";
        $paper = Paper::find($id);
        $contract = Contract::where('employee_id',$paper->employee_id)->where('cancel',0)->where('extension',1)->get()->first();

        return view($view)->with('paper',$paper)->with('contract',$contract);
    }
}
