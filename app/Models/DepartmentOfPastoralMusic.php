<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class DepartmentOfPastoralMusic extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;
    
    protected $fillable = ['title_en','title_ko','content_en','content_ko'];
}
