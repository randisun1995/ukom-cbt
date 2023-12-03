<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminerGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'examsession_id',
        'participant_id',
        'examiner_id',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
    public function examiner()
    {
        return $this->belongsTo(Examiner::class);
    }
    // public function examgroup()
    // {
    //     return $this->belongsTo(ExamGroup::class);
    // }
}
