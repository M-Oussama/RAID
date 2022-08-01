<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $with = [
        'employee',
        'paperType'
    ];
    public function employee(){
        return $this->belongsTo(Employees::class);
    }
    public function paperType(){
        return $this->belongsTo(PaperType::class);
    }

}
