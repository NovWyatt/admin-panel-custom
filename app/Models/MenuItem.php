<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'title',
        'url',
        'target',
        'icon_class',
        'parent_id',
        'order',
        'route',
        'parameters',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'array',
        'active' => 'boolean',
    ];

    /**
     * Get the menu that owns the menu item.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the parent menu item.
     */
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get the children menu items.
     */
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->with('children')->orderBy('order');
    }
}