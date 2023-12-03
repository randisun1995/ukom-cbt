<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Examiner extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'nip',
        'name',
        'role',
        'examsession_id',
        'password',


    ];

    public function examiner_groups()
    {
        return $this->hasMany(ExaminerGroup::class);
    }
    public function examsession()
    {
        return $this->belongsTo(ExamSession::class);
    }
}
