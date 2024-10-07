<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class Payment extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'payment_id', 'student_id', 'amount', 'note', 'attachment', 'status', 'type'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function dueStudents()
    {
        return $this->belongsToMany(Student::class, 'payment_due_students', 'payment_id')->withPivot('due_payments','credit');
    }
}
