<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentSubjectAssignmentAttachment extends Model
{
    use SoftDeletes;

    protected $fillable=['student_assignment_submit_id', 'file', 'file_name', 'status'];

}
