<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
class Page extends Model
{
    use HasFactory, SoftDeletes, PowerJoins;

    protected $fillable = [
        'menu_id', 'sub_id', 'title', 'title_ko', 'description', 'description_ko', 'meta_title', 'meta_description', 'status', 'can_delete'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function submenu()
    {
        return $this->belongsTo(SubMenu::class, 'sub_id');
    }
}
