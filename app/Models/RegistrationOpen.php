<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class RegistrationOpen extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'semester_id',
        'start_date',
        'end_date'
    ];

    protected $dates = [
        'start_date', 'end_date'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
