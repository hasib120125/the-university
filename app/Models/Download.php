<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Download extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = ['title_en','title_ko','content_en','content_ko', 'file_path'];
}
