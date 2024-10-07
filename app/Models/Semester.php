<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class Semester extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = ['semester_code', 'year', 'season', 'start_period', 'end_period', 'last_subject_cancel_date', 'grade_period'];

    protected $dates = [
        'start_period', 'end_period', 'last_subject_cancel_date', 'grade_period'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
