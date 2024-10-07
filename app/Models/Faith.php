<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class Faith extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;
    protected $fillable = [
        'student_id',
        'name',
        'location',
        'office',
        'denomination',
        'year_of_faith'
    ];

}
