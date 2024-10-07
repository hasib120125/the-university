<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kirschbaum\PowerJoins\PowerJoins;
class LectureMaterialComment extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'lecture_material_id', 'student_id', 'comment', 'reply', 'admin_id', 'replied_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
