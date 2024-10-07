<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class ProfessorEducation extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'professor_id', 'school', 'scholarship_s', 'scholarship_f', 'degree'
    ];

    protected $dates=[
        'scholarship_s', 'scholarship_f'
    ];
}
