<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjectPlan extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'subject_id',
        'semester_id',
        'subject_outline',
        'textbook',
        'reference_book',
        'evaluation_standard',
        'attendance',
        'middle',
        'ending',
        'etc',
        'attendance_mark',
        'middle_mark',
        'ending_mark',
        'etc_mark',
    ];

    protected static function booted()
    {
        static::deleting(function ($subjectPlan) {
            $subjectPlan->subjectPlanTopics()->delete();
        });
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function subjectPlanTopics()
    {
        return $this->hasMany(SubjectPlanTopic::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
