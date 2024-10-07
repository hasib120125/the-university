<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kirschbaum\PowerJoins\PowerJoins;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, PowerJoins;

    protected $fillable = [
        'student_no', 'name_hangul', 'name_chinese', 'name_english', 'password', 'photo', 'email', 'address', 'department_id',
        'semester_id', 'citizenship_no', 'dob', 'mobile', 'last_education_start', 'last_education_end', 'last_school_name',
        'graduate_plan', 'last_education_department', 'last_education_special', 'motive', 'job_company', 'job_position', 'job_address',
        'remark', 'status', 'degree_number', 'withdrawal_date', 'admission_date', 'graduation_date', 'admit_status', 'bible_exam',
        'gender', 'phone', 'confention_faith_file', 'study_plan', 'theological_dissertation_file', 'active', 'available_credit',
        'leave_start_date', 'leave_end_date', 'due_payments', 'church_name', 'grade', 'point_value'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'dob', 'last_education_start', 'last_education_end', 'withdrawal_date', 'admission_date', 'graduation_date', 'leave_start_date', 'leave_end_date'
    ];

    public function attachments()
    {
        return $this->hasMany(StudentAttachment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function submittedAssignments()
    {
        return $this->hasMany(StudentAssignmentSubmit::class, 'student_id');
    }

    public function activeSubjects()
    {
        return $this->hasMany(SubjectActiveStudent::class);
    }

    public function answeredQuestions()
    {
        return $this->hasMany(SubjectExamAnswer::class, 'student_id', 'id');
    }

    public function faiths()
    {
        return $this->hasMany(Faith::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function duePayments()
    {
        return $this->belongsToMany(Payment::class, 'payment_due_students', 'student_id')->withPivot('due_payments', 'credit');
    }
}
