<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the menu items for the menu.
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class)->with('children')->whereNull('parent_id')->orderBy('order');
    }
}