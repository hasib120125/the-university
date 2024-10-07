<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Feature extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'name', 'name_ko', 'text', 'text_ko', 'image', 'status'
    ];
}
