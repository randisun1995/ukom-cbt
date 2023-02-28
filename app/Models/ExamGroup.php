<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'exam_session_id',
        'participant_id',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function exam_session()
    {
        return $this->belongsTo(ExamSession::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
