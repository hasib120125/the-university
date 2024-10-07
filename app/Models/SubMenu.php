<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;

class SubMenu extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;
    protected $fillable = [
        'name', 'name_ko', 'slug', 'menu_id', 'sort', 'status', 'can_delete'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
