<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class StudentGrade extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'subject_id',
        'subject_name',
        'credit',
        'student_id',
        'student_no',
        'semester_id',
        'semester_code',
        'semester_year',
        'semester_season',
        'attendance',
        'middle',
        'ending',
        'etc',
        'score',
        'attendance_rate',
        'grade',
        'grades',
        'calculated',
        'pass',
        'non_pass',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subjectPlans()
    {
        return $this->hasMany(SubjectPlan::class, 'subject_id', 'subject_id')->withTrashed();
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
