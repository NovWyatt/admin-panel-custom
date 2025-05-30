<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRow extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data_type_id',
        'field',
        'type',
        'display_name',
        'required',
        'browse',
        'read',
        'edit',
        'add',
        'delete',
        'details',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'required' => 'boolean',
        'browse' => 'boolean',
        'read' => 'boolean',
        'edit' => 'boolean',
        'add' => 'boolean',
        'delete' => 'boolean',
        'details' => 'array',
    ];

    /**
     * Get the data type that owns the row.
     */
    public function dataType()
    {
        return $this->belongsTo(DataType::class);
    }
}