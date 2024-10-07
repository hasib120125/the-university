<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjectNotice extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'title', 'subject_id', 'semester_id', 'description', 'attachment1', 'attachment2', 'attachment1_original_filename',
        'attachment2_original_filename'
    ];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function comments()
    {
        return $this->hasMany(SubjectNoticeComment::class)->with('student')->latest();
    }

    protected static function booted()
    {
        static::updating(function ($notice) {
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
