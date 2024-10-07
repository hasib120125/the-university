<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class LectureQA extends Model
{
    use HasFactory, PowerJoins;

    protected $table = 'lecture_qas';

    protected $fillable = [
        'lecture_id',
        'lecture_management_id',
        'student_id',
        'type',
        'title',
        'details',
        'like',
        'liked_users'
    ];

    public function getLikedUsersAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    protected $casts = [
        'liked_users' => 'array'
    ];

    public function setLikedUsersAttribute($value)
    {
        $this->attributes['liked_users'] = json_encode($value);
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function management()
    {
        return $this->hasOne(LectureManagement::class, 'id', 'lecture_management_id');
    }

    public function lecture()
    {
        return $this->hasOne(Lecture::class, 'id', 'lecture_id');
    }

    public function replies()
    {
        return $this->hasMany(LectureQAReply::class, 'lecture_qa_id');
    }
}
