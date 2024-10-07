<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;

class LectureManagement extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;
    protected $fillable = [
        'lecture_id', 'lecture_number', 'lecture_name', 'audio', 'file', 'video_running_time',
        'description', 'start_period', 'end_period', 'original_video', 'duration', 'smil', 'q_480',
        'q_720', 'q_1080', 'convert_status', 'thumbs', 'audio_duration'
    ];

    protected $dates = [
        'start_period', 'end_period'
    ];

    public function lecture() {
        return $this->belongsTo(Lecture::class);
    }

    public function progress()
    {
        return $this->hasMany(LectureManagementProgress::class)
            ->where('student_id', Auth::user()->id);
    }

    protected static function booted()
    {
        static::updating(function ($management) {
            if ($management->file != $management->getOriginal('file')) {
                if (Storage::exists($management->getOriginal('file'))) {
                    Storage::delete($management->getOriginal('file'));
                }

                if (Storage::exists($management->getOriginal('audio'))) {
                    Storage::delete($management->getOriginal('audio'));
                }

                if (Storage::exists($management->getOriginal('thumbs'))) {
                    Storage::delete($management->getOriginal('thumbs'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('original_video'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('original_video'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('smil'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('smil'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('q_480'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('q_480'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('q_720'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('q_720'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('q_1080'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('q_1080'));
                }
            }
        });

        static::deleting(function ($management) {
            if ($management->file != $management->getOriginal('file')) {
                if (Storage::exists($management->getOriginal('file'))) {
                    Storage::delete($management->getOriginal('file'));
                }
                if (Storage::exists($management->getOriginal('audio'))) {
                    Storage::delete($management->getOriginal('audio'));
                }

                if (Storage::exists($management->getOriginal('thumbs'))) {
                    Storage::delete($management->getOriginal('thumbs'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('original_video'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('original_video'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('smil'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('smil'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('q_480'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('q_480'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('q_720'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('q_720'));
                }

                if (Storage::disk('media_server')->exists($management->getOriginal('q_1080'))) {
                    Storage::disk('media_server')->delete($management->getOriginal('q_1080'));
                }
            }
        });
    }
}
