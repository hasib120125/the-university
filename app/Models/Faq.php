<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Faq extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'question', 'answer', 'status'
    ];
}
