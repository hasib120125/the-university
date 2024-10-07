<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class StaticPage extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'page_id', 'slug', 'title_en', 'title_ko', 'content_en', 'content_ko'
    ];
}
