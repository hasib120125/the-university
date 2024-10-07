<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;
class OfflineSeminar extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = ['title_en','title_ko','content_en','content_ko', 'preview_image'];

    protected static function booted()
    {
        static::deleting(function ($model) {
            if(Storage::exists($model->preview_image))
                Storage::delete($model->preview_image);
        });
    }

}
