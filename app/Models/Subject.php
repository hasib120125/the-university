<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class Subject extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'name', 'code', 'credit', 'professor_id', 'status', 'max_student'
    ];

    protected static function booted()
    {
        static::deleting(function ($subject) {
            $subject->notices()->delete();
            $subject->subjectPlans()->delete();
            $subject->assignments()->delete();
            $subject->materials()->delete();
            $subject->exams()->delete();
            $subject->lectures()->delete();
        });
    }

    public function notes()
    {
        return $this->hasMany(SubjectNote::class);
    }

    public function assignments()
    {
        return $this->hasMany(SubjectAssignment::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_subject')->withPivot('subject_type');
    }

    public function notices()
    {
        return $this->hasMany(SubjectNotice::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function subjectPlans()
    {
        return $this->hasMany(SubjectPlan::class);
    }

    public function materials()
    {
        return $this->hasMany(SubjectMaterial::class);
    }

    public function exams()
    {
        return $this->hasMany(SubjectExam::class);
    }

    public function activeStudents()
    {
        return $this->hasMany(SubjectActiveStudent::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
