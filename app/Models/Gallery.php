<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;
class Gallery extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = ['name_en', 'name_kr', 'description_kr', 'description_en'];

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }

    protected static function booted()
    {
        static::deleting(function ($gallery) {
            foreach ($gallery->images as $image)
                $image->delete();
        });
    }
}
