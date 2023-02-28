<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Participant extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'level_id',
        'nip',
        'name',
        'password',
        'instansi_id',
        'type'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
