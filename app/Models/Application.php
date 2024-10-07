<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class Application extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = ['student_id', 'subject', 'status'];

    public function attachments()
    {
        return $this->hasMany(ApplicationAttachment::class);
    }
}
