<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'examiner_group_id',
        'participant_id',
        'indicator_id',
        'score',
    ];

    public function examiner_group()
    {
        return $this->belongsTo(ExaminerGroup::class);
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }
}
