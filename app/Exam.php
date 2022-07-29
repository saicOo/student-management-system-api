<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'id','course_id',
    ];
    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }
}
