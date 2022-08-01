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

        foreach($papers_type as $item){
            $paper = new PaperType();
            $paper->name = $item;
            $paper->save();
        }
    }
}
