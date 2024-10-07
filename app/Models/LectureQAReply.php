<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class LectureQAReply extends Model
{
    use HasFactory, PowerJoins;

    protected $table = 'lecture_qa_replies';

    protected $fillable = [
        'lecture_qa_id',
        'user_id',
        'user_type',
        'reply',
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
        return $this->belongsTo(Student::class, 'user_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Student::class, 'user_id', 'id');
    }
}
