<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'level_id',
        'position_id',
        'duration',
        'description',
        'random_question',
        'random_answer',
        'show_answer',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('id', 'DESC');
    }
}
