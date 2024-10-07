<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;

class LectureMaterial extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'title', 'lecture_id', 'description', 'attachment1', 'attachment2'
    ];

    public function lecture() {
        return $this->belongsTo(Lecture::class);
    }

    public function comments()
    {
        return $this->hasMany(LectureMaterialComment::class)->latest();
    }

    protected static function booted()
    {
        static::updating(function ($material) {
            if ($material->attachment1 != $material->getOriginal('attachment1')) {
                if (Storage::exists($material->getOriginal('attachment1'))) {
                    Storage::delete($material->getOriginal('attachment1'));
                }
            }

            if ($material->attachment2 != $material->getOriginal('attachment2')) {
                if (Storage::exists($material->getOriginal('attachment2'))) {
                    Storage::delete($material->getOriginal('attachment2'));
                }
            }
        });
    }
}
