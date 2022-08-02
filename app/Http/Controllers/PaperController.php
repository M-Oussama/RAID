<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employees;
use App\Models\Paper;
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
            "تمديد عقد رئيس موقع فوج",
            "تمديد عقد عون أمن",
            "محضر تقاضي المستحقات",
            "قرار تحويل",
            "شهادة عمل",
            "بطاقـــــة معلومــــات",
            "بطاقة فردية خاصة بالملابس",
            "العطلة",
            "إستفسار",
            "إستدعاء",


        );

        $papers = [];

             $counter = 1;
        foreach($papers_type as $item){

          $paper =  new \stdClass();
          $paper->id = $counter;
          $paper->title = $item;
          array_push($papers,$paper);
            $counter++;
        }

        $employees = Employees::all();

        return view('dashboard.paper.index')->with('papers',json_encode($papers))->with('employees',$employees);
    }

    public function papersList()
    {
        $papers = Paper::all();

        return view('dashboard.paper.list_of_papers')->with('papers',$papers);
    }

    public function exportContract($id){
        $contract = Contract::find($id);

        return view('dashboard.paper.papers.contract')->with('contract',$contract);
    }

    public function exportPaper(Request $request,$id){


        $view = "";

       // $paper = new Paper();
       // $paper->paper_type = $request->paper_type;
       // $paper->employee_id = $request->employee_id;
       // $paper->save();



        switch ($id){
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

                $paper = new Paper();
                $paper->paper_type_id = $id;
                $paper->employee_id = $request->employee_id;
                $paper->save();

                return redirect("/dash/papers/list");
                //$employee = Employees::find($request->employee_id);

                //return view($view)->with('employee',$employee)->with('paper',$paper);

                break;
            }
            case 6: {

                // قرار تحويل
                $view = "dashboard.paper.papers.mutation";

                break;
            }
            case 7: {
                // شهادة عمل
                $view = "dashboard.paper.papers.business_certificate";

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
                $view = "dashboard.paper.papers.clothes_card";
                break;
            }
            case 10: {
                // العطلة
                $view = "dashboard.paper.papers.vacation";
                break;
            }
            case 11: {
                // إستفسار
                $view = "dashboard.paper.papers.inquiry";
                break;
            }
            case 12: {
                // إستدعاء
                $view = "dashboard.paper.papers.call";
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

                return view($view)->with('paper',$paper);

                break;
            }
            case 6: {

                // قرار تحويل
                $view = "dashboard.paper.papers.mutation";

                break;
            }
            case 7: {
                // شهادة عمل
                $view = "dashboard.paper.papers.business_certificate";

                break;
            }
            case 8: {
                // بطاقـــــة معلومــــات
                $view = "dashboard.paper.papers.information_card";
                break;
            }
            case 9: {
                // بطاقة فردية خاصة بالملابس
                $view = "dashboard.paper.papers.clothes_card";
                break;
            }
            case 10: {
                // العطلة
                $view = "dashboard.paper.papers.vacation";
                break;
            }
            case 11: {
                // إستفسار
                $view = "dashboard.paper.papers.inquiry";
                break;
            }
            case 12: {
                // إستدعاء
                $view = "dashboard.paper.papers.call";
                break;
            }
            default: return redirect("/dash/papers");

        }


        return view($view);
    }
}
