<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'display_name_singular',
        'display_name_plural',
        'icon',
        'model_name',
        'controller',
        'description',
        'generate_permissions',
        'server_side',
        'details',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'generate_permissions' => 'boolean',
        'server_side' => 'boolean',
        'details' => 'array',
    ];

    /**
     * Get the rows for the data type.
     */
    public function rows()
    {
        return $this->hasMany(DataRow::class);
    }
}