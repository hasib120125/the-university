<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class ProfessorCareer extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'professor_id', 'position','employer','department','period'
    ];
}
