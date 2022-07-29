<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    protected $fillable = [
        'course_id', 'student_id','exam_id',
    ];
    public $timestamps = false;
}
