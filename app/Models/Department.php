<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class Department extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'name', 'code', 'degree', 'status'
    ];

    public function majors()
    {
        return $this->belongsToMany(Lecture::class, 'lecture_major')->withPivot('id', 'grade_year_1', 'grade_year_2', 'grade_year_3', 'grade_year_4', 'grade', 'major_category');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
