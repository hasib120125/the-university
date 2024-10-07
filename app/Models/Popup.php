<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Popup extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'title', 'content', 'left', 'top'
    ];
}
