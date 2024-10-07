<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class StudentAttachment extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = ['student_id', 'orginal_name', 'attachment'];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->attachment != $model->getOriginal('attachment')) {
                if (Storage::exists($model->getOriginal('attachment'))) {
                    Storage::delete($model->getOriginal('attachment'));
                }
            }
        });

        static::deleting(function ($model) {
            if ($model->attachment != $model->getOriginal('attachment')) {
                if (Storage::exists($model->getOriginal('attachment'))) {
                    Storage::delete($model->getOriginal('attachment'));
                }
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
