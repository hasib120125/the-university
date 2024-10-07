<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class LectureNote extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'lecture_id', 'lecture_management_id', 'student_id', 'time', 'note'
    ];

    public function lectureManagement()
    {
        return $this->belongsTo(LectureManagement::class);
    }
}
