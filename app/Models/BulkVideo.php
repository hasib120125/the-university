<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class BulkVideo extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'filename', 'original_video', 'duration', 'thumbs', 'smil', 'q_480', 'q_720', 'q_1080', 'convert_status',
        'original_filename', 'fail', 'can_assign'
    ];

}
