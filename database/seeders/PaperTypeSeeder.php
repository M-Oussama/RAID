<?php

namespace Database\Seeders;

use App\Models\Paper;
use App\Models\PaperType;
use Illuminate\Database\Seeder;

class PaperTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

        $i = 1;
        foreach($papers_type as $item){
            $paper = new PaperType();
            $paper->name = $item;
            if($i== 3 || $i== 4)
                $paper->active = false;
            $paper->save();
            $i++;
        }
    }
}
