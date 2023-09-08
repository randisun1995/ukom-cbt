<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraiserGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'participant_id',
        'appraiser_id',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
    public function appraiser()
    {
        return $this->belongsTo(Participant::class);
    }
}
