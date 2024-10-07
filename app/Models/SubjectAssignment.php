<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjectAssignment extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'assignment_title', 'subject_id', 'semester_id','start_period', 'end_period', 'task_type', 'end_open', 'description', 'attachment1', 'attachment2',
        'attachment1_original_filename', 'attachment2_original_filename'
    ];

    protected $dates = [
        'start_period', 'end_period'
    ];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    protected static function booted()
    {
        static::updating(function ($assignment) {
            if ($assignment->attachment1 != $assignment->getOriginal('attachment1')) {
                if (Storage::exists($assignment->getOriginal('attachment1'))) {
                    Storage::delete($assignment->getOriginal('attachment1'));
                }
            }

            if ($assignment->attachment2 != $assignment->getOriginal('attachment2')) {
                if (Storage::exists($assignment->getOriginal('attachment2'))) {
                    Storage::delete($assignment->getOriginal('attachment2'));
                }
            }
        });
    }

    public function studentAssignmentSubmit()
    {
        return $this->hasOne(StudentAssignmentSubmit::class, 'subject_assignment_id');
    }
}
