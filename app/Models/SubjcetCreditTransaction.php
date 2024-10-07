<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjcetCreditTransaction extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = ['subject_id','student_id','credit'];
}
