<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class LectureProgress extends Model
{
    use HasFactory, PowerJoins;

    protected $guarded = [];

    protected $dates = ['completed_at'];
}
