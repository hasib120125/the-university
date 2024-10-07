<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class OtherFee extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'entrance',
        'seminar_fees',
        'student_union',
        'orientation'
    ];
}
