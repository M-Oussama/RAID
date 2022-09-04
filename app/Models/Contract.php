<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Employees
 *
 * @property int $id
 * @property \App\Models\Employees|null $employee_id
 * @property string|null $recruitment_date
 * @property string|null $insurance_date
 * @property string|null $post
 * @property string|null $post_location
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $contract_length
 * @property string|null $exp_end_date
 * @property string|null $salary
 *
 *
 **/
class Contract extends Model
{
    use HasFactory;

    protected  $with= [
        'employee'
        ];
    public function employee(){
        return $this->belongsTo(Employees::class,'employee_id');
    }
}
