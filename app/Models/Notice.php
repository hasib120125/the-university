<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;

class Notice extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'subject', 'category', 'description', 'attachment1', 'attachment2', 'attachment1_original_filename',
        'attachment2_original_filename', 'status'
    ];

    protected static function booted()
    {
        static::saving(function ($notice) {
            if ($notice->attachment1 != $notice->getOriginal('attachment1')) {
                if (Storage::exists($notice->getOriginal('attachment1'))) {
                    Storage::delete($notice->getOriginal('attachment1'));
                }
            }

            if ($notice->attachment2 != $notice->getOriginal('attachment2')) {
                if (Storage::exists($notice->getOriginal('attachment2'))) {
                    Storage::delete($notice->getOriginal('attachment2'));
                }
            }
        });
    }
}
