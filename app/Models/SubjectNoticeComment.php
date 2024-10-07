<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class SubjectNoticeComment extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'subject_notice_id', 'student_id', 'comment', 'reply', 'admin_id', 'replied_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
