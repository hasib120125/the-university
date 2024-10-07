<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;

class Lecture extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'name',
        'subject_id',
        'professor_id',
        'semester_id',
        'bulk_video_id',
        'bulk_audio_id',
        'bulk_subtitle_id',
        'start_period',
        'end_period',
        'description',
        'audio_file',
        'audio_duration',
        'original_video_file',
        'thumbs',
        'original_video',
        'duration',
        'subtitle_file',
        'subtitle_label',
        'smil',
        'q_480',
        'q_720',
        'q_1080',
        'convert_status',
        'status',
        'fail',
    ];

    protected $dates = [
        'start_period', 'end_period'
    ];


    public function progress()
    {
        return $this->hasMany(LectureProgress::class)
            ->where('student_id', Auth::user()->id);
    }

    public function lectureProgress()
    {
        return $this->hasMany(LectureProgress::class);
    }

    protected static function booted()
    {
        /*static::updating(function ($lecture) {
            if ($lecture->original_video_file != $lecture->getOriginal('original_video_file') && !$lecture->getOriginal('bulk_video_id')) {
                if (Storage::exists($lecture->getOriginal('original_video_file'))) {
                    Storage::delete($lecture->getOriginal('original_video_file'));
                }

                if (Storage::exists($lecture->getOriginal('audio_file'))) {
                    Storage::delete($lecture->getOriginal('audio_file'));
                }

                if (Storage::exists($lecture->getOriginal('thumbs'))) {
                    Storage::delete($lecture->getOriginal('thumbs'));
                }

                if (Storage::disk('media_server')->exists($lecture->getOriginal('original_video'))) {
                    Storage::disk('media_server')->delete($lecture->getOriginal('original_video'));
                }

                if (Storage::disk('media_server')->exists($lecture->getOriginal('smil'))) {
                    Storage::disk('media_server')->delete($lecture->getOriginal('smil'));
                }

                if (Storage::disk('media_server')->exists($lecture->getOriginal('q_480'))) {
                    Storage::disk('media_server')->delete($lecture->getOriginal('q_480'));
                }

                if (Storage::disk('media_server')->exists($lecture->getOriginal('q_720'))) {
                    Storage::disk('media_server')->delete($lecture->getOriginal('q_720'));
                }

                if (Storage::disk('media_server')->exists($lecture->getOriginal('q_1080'))) {
                    Storage::disk('media_server')->delete($lecture->getOriginal('q_1080'));
                }
            }
        });*/

        static::deleting(function ($lecture) {
            if (!$lecture->bulk_video_id) {
                if (Storage::disk('media_server')->exists($lecture->original_video)) {
                    Storage::disk('media_server')->delete($lecture->original_video);
                }

                if (Storage::exists($lecture->original_video_file)) {
                    Storage::delete($lecture->original_video_file);
                }
            }

            if (Storage::disk('media_server')->exists($lecture->smil)) {
                Storage::disk('media_server')->delete($lecture->smil);
            }

            if (Storage::disk('media_server')->exists($lecture->q_480)) {
                Storage::disk('media_server')->delete($lecture->q_480);
            }

            if (Storage::disk('media_server')->exists($lecture->q_720)) {
                Storage::disk('media_server')->delete($lecture->q_720);
            }

            if (Storage::disk('media_server')->exists($lecture->q_1080)) {
                Storage::disk('media_server')->delete($lecture->q_1080);
            }

            if (Storage::exists($lecture->audio_file)) {
                Storage::delete($lecture->audio_file);
            }

            if (Storage::exists($lecture->thumbs)) {
                Storage::delete($lecture->thumbs);
            }
        });
    }

    public function bulkAudio()
    {
        return $this->belongsTo(BulkAudio::class);
    }

    public function bulkVideo()
    {
        return $this->belongsTo(BulkVideo::class);
    }
    public function bulkSubtitle()
    {
        return $this->belongsTo(BulkSubtitle::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function materials()
    {
        return $this->hasMany(LectureMaterial::class);
    }

    public function assignments()
    {
        return $this->hasMany(LectureAssignment::class);
    }

    public function managements()
    {
        return $this->hasMany(LectureManagement::class);
    }

    public function exams()
    {
        return $this->hasMany(LectureExam::class);
    }

    public function subjectPlan()
    {
        return $this->hasMany(SubjectPlan::class)->orderBy('date');
    }

    public function activeStudents()
    {
        return $this->belongsToMany(Student::class, 'lecture_active_students');
    }

    public function majors()
    {
        return $this->belongsToMany(Curriculum::class, 'lecture_major')->withPivot('id', 'grade_year_1', 'grade_year_2', 'grade_year_3', 'grade_year_4', 'grade', 'major_category');
    }

    public function notes()
    {
        return $this->hasMany(LectureNote::class);
    }
}
