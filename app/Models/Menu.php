<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class Menu extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;
    protected $fillable = [
        'name', 'name_ko', 'slug', 'sort', 'status','can_delete'
    ];

    public function submenus()
    {
        return $this->hasMany(SubMenu::class, 'menu_id');
    }
}
