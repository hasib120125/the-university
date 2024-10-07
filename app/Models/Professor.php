<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kirschbaum\PowerJoins\PowerJoins;

class Professor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, PowerJoins;

    protected $fillable = [
        'name_hangul', 'name_chinese', 'name_english', 'email', 'dob', 'photo', 'address', 'department_id', 'mobile','status','password','professor_no','phone','custom_subject_id',
        'details', 'details_image'
    ];

    protected $dates = [
        'dob'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function customSubject()
    {
        return $this->belongsTo(CustomSubject::class, 'custom_subject_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
