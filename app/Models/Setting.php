<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Setting extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'credit_rate', 'current_semester_id', 'home_video', 'university_name','university_address', 'phone_number','audio_image'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'current_semester_id');
    }
}
