<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class CurriculumFee extends Model
{
    use HasFactory, SoftDeletes,PowerJoins;
    protected $fillable = [
        'semester_id', 'curriculum_id','grade','subject_fee','orientation_fee','others_fee'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }

}
