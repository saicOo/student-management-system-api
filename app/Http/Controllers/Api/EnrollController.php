<?php

namespace App\Http\Controllers\Api;
use App\Enroll;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnrollController extends Controller
{
    public function Enroll($coures_id)
    {
        $student_id = auth()->user()->id;
        $getIdStudent = Enroll::where('student_id',$student_id)->count();
        if($getIdStudent < 1){
            // $EnrollStatus = Enroll::where('student_id',auth()->user()->id);
            $Enroll = new Enroll;
            $Enroll->student_id = $student_id;
            $Enroll->course_id = $coures_id;
            $Enroll->save();
            return response()->json([
                'message' => 'Registered, wait for the code message',
            ]);

    }else{
        return response()->json([
            'message' => 'Cannot enroll again',
        ]);
    }
    }
}
