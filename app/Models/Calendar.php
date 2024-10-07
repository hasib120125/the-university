<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class Calendar extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = ['title', 'type', 'description', 'date'];

    protected $dates = [
        'date'
    ];
    
}
