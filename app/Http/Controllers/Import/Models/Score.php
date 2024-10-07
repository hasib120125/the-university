<?php

namespace App\Http\Controllers\Import\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $connection = 'old';
    protected $table = 'score';
    protected $primaryKey = 'IDX';

    protected $guarded = [];

    public function lecture() {
        return $this->hasOne(OldLecture::class, 'LECTURE_CODE', 'LECTURE_CODE');
    }
}
