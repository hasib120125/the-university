<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class SubjectPlanTopic extends Model
{
    use PowerJoins;

    protected $fillable = ['subject_plan_id','subject_id','date','topic','remark'];

    protected $dates = [
        'date'
    ];

    public function subject() {
        return $this->belongsToMany(Subject::class);
    }

    public function subjectPlan() {
        return $this->belongsTo(SubjectPlan::class);
    }
    
}
