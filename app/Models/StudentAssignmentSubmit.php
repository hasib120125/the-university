<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAssignmentSubmit extends Model
{
    use SoftDeletes;

    protected $fillable=['student_id', 'subject_assignment_id','status'];

    public function attachments()
    {
        return $this->hasMany(StudentSubjectAssignmentAttachment::class, 'student_assignment_submit_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
