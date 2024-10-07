<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class ApplicationAttachment extends Model
{
    use HasFactory, PowerJoins;

    protected $fillable = ['application_id', 'file', 'file_name'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
