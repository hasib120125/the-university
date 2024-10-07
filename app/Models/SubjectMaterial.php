<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjectMaterial extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'subject_id', 'semester_id', 'title', 'description', 'attachment1', 'attachment2', 'attachment1_original_filename',
        'attachment2_original_filename'
    ];

    public function comments()
    {
        return $this->hasMany(SubjectMaterialComment::class);
    }
}
