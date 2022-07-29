<?php

namespace App\Http\Controllers\Api;
use App\Student;
use App\Enroll;
use Illuminate\support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::all();
    }

    public function show($id)
    {
        return Student::findOrFail($id);
    }

    public function sendCode($id)
    {
        $enrollCount = Enroll::firstWhere('student_id',$id);
        if($enrollCount){
            $student = Student::findOrFail($id);
            if($student->code){
                return response()->json([
                    'message' => 'Already sent!!!!',
                ]);
            }else{
                $code = Str::random(8);
                $student->code = $code;
                $student->save();
                $codeToken = array(
                    'studentCode' => $student->code,
                );
                return response()->json([
                    'message' => 'The code has been generated successfully',
                    'codeToken' => $codeToken,
                ]);
            }

    }else{
        return response()->json([
            'message' => 'This student is not registered',
        ]);
    }
    }
}
