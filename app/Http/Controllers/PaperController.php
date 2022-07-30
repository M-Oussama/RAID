<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employees;
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


        "تمديد عقد رئيس موقع فوج",
            "تمديد عقد عون أمن",
            "عقد عمل رئيس موقع ورئيس فوج",
            "غقد عمل لعون الأمن",
            "محضر تنصب",
            "محضر تقاضي المستحقات",
            "قرار تحويل",
            "شهادة عمل",
            "بطاقـــــة معلومــــات",
            "بطاقة فردية خاصة بالملابس",
            "العطلة",
            "إستفسار",
            "إستدعاء"

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


        return view('dashboard.paper.index')->with('papers',json_encode($papers));
    }
}
