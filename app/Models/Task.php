<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'job_id',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function usertasks()
    {
        return $this->hasMany(UserTask::class);
    }
}
