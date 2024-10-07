<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class Category extends Model
{
    use PowerJoins;
    protected $fillable = [
        'name', 'status', 'sort'
    ];

    public function subCategories() {
        return $this->belongsTo(SubCategory::class, 'id');
    }
}
