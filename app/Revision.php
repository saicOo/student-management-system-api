<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $fillable = [
        'answers_wrong', 'answers_correct', 'exam_id','student_id',
    ];
}
