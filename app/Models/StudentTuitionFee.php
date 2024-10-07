<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class StudentTuitionFee extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected  $fillable = [
        'student_id', 'tuition_fee', 'enterance_fee', 'seminar_fee', 'student_union_fee', 'orientation_fee', 'deduction', 'scholarship'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
