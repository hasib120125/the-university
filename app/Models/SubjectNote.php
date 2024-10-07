<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjectNote extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'subject_id', 'lecture_id', 'student_id', 'time', 'note'
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
