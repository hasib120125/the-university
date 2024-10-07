<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjectExamAnswer extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'subject_exam_id',
        'subject_exam_question_id',
        'student_id',
        'answer',
        'correct',
        'score'
    ];
    
}
