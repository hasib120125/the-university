<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;

class GalleryImage extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = ['gallery_id', 'image', 'thumbs', 'sort'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    protected static function booted()
    {
        static::deleting(function ($image) {
            if(Storage::exists($image->image))
                Storage::delete($image->image);
        });
    }
}
