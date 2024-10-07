<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class Transcript extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = ['issue_no', 'student_id'];
}
