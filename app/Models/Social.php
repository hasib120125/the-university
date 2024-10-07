<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Social extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'name', 'url', 'class', 'status'
    ];
}
