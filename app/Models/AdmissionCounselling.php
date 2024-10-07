<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class AdmissionCounselling extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = ['question_en','question_ko','answer_en','answer_ko'];
    
}
