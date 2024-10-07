<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SampleLecture extends Model
{
    protected $fillable = ['video', 'sort', 'thumbs'];

    protected static function booted()
    {
        static::deleting(function ($model) {
            if(Storage::exists($model->video)) Storage::delete($model->video);
        });
    }
}
