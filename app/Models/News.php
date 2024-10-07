<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Kirschbaum\PowerJoins\PowerJoins;
class News extends Model
{
    use HasFactory, SoftDeletes, Sluggable, PowerJoins;

    protected $fillable = [
        'slug',
        'title_en', 
        'title_ko',
        'content_en', 
        'content_ko',
        'summary_en',
        'summary_ko',
        'cover',
        'thumbs'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title_en'
            ]
        ];
    }
}
