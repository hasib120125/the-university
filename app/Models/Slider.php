<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class Slider extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'heading', 'text', 'url', 'image'
    ];
}
