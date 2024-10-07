<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class CreditTransaction extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = [
        'payment_id', 'student_id', 'credit', 'per_credit_rate', 'type'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
