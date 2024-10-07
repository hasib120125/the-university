<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SubjectActiveStudents extends Pivot
{
    protected $table = 'subject_active_students';

    public function semester()
    {
        return $this->belongsTo(Semester::class)->withTrashed();
    } 
}
