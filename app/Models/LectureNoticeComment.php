<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class LectureNoticeComment extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'lecture_notice_id', 'student_id', 'comment', 'reply', 'admin_id', 'replied_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
