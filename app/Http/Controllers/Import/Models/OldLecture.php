<?php

namespace App\Http\Controllers\Import\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldLecture extends Model
{
    use HasFactory;

    protected $connection = 'old';
    protected $table = 'waics_lms_dbo_lecture';
    protected $primaryKey = 'IDX';
    protected $guarded = [];
}
