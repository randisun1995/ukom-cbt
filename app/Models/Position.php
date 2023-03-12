<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'level_id',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
