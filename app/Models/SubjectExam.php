<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjectExam extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'subject_id',
        'semester_id',
        'title',
        'start_period',
        'end_period',
        'time_limit',
        'exam_type',
        'status',
    ];

    protected $dates = [
        'start_period', 'end_period'
    ];

    protected static function booted()
    {
        static::deleting(function ($exam) {
            $exam->questions()->delete();
        });
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function questions() {
        return $this->hasMany(ExamQuestion::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'subject_exam_student', 'subject_exam_id', 'student_id')->withPivot('start_time','end_time');
    }

    public function currentStudent()
    {
        return $this->students()->where('student_id',  Auth::guard('student')->user()->id);
    }
}
