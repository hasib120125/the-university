<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;

class ExamQuestion extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'subject_exam_id',
        'question_type',
        'difficulty',
        'quater_code',
        'title',
        'problem_related_image',
        'attachment',
        'answer',
        'marks',
        'mcq1',
        'mcq2',
        'mcq3',
        'mcq4',
        'mcq5'
    ];

    protected static function booted()
    {
        static::updating(function ($question) {
            if ($question->attachment != $question->getOriginal('attachment')) {
                if (Storage::exists($question->getOriginal('attachment'))) {
                    Storage::delete($question->getOriginal('attachment'));
                }
            }

            if ($question->problem_related_image != $question->getOriginal('problem_related_image')) {
                if (Storage::exists($question->getOriginal('problem_related_image'))) {
                    Storage::delete($question->getOriginal('problem_related_image'));
                }
            }
        });

        static::deleting(function ($question) {
            if ($question->attachment != $question->getOriginal('attachment')) {
                if (Storage::exists($question->getOriginal('attachment'))) {
                    Storage::delete($question->getOriginal('attachment'));
                }
            }

            if ($question->problem_related_image != $question->getOriginal('problem_related_image')) {
                if (Storage::exists($question->getOriginal('problem_related_image'))) {
                    Storage::delete($question->getOriginal('problem_related_image'));
                }
            }
        });
    }

    public function exam() {
        return $this->belongsTo(SubjectExam::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(SubjectExamAnswer::class,'subject_exam_question_id','id');
    }
}
