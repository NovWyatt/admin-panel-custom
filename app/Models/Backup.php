<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'path',
        'size',
    ];

    /**
     * Get the user that created the backup.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}