<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    protected $fillable = [
        'course_id', 'student_id','exam_id',
    ];
    public $timestamps = false;
    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }
    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }
    public function exam()
    {
        return $this->belongsTo('App\Exam', 'exam_id');
    }
}
