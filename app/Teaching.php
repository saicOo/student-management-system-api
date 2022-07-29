<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    protected $fillable = [
        'course_id', 'trainer_id',
    ];
    
    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }
    public function trainer()
    {
        return $this->belongsTo('App\Trainer', 'trainer_id');
    }
}
