<?php

namespace App\Http\Controllers\Api;
use App\Exam;
use App\Enroll;
use App\Question;
use App\Revision;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function checkCodeExam(Request $request,$course_id)
    {
        $student_id = auth()->user()->id;
        $checkEnroll = Enroll::firstWhere('student_id',$student_id)->firstWhere('course_id',$course_id);
        $checkExam = Exam::firstWhere('course_id',$course_id);

        if(auth()->user()->code === $request->code && $checkEnroll && $checkExam){

            if(!$checkEnroll->exam_id){
                $exam_id = Exam::where('course_id',$course_id)->inRandomOrder()->first()->id;
                $exam = Question::where('exam_id',$exam_id)->get();
                $enrollExam = Enroll::firstWhere('student_id',$student_id);
                $enrollExam->exam_id = $exam_id;
                $enrollExam->save();
                return response()->json([
                    'message' => 'Exam is registered',
                    'exam_id' => $exam_id,
                    'exam' => $exam,
                ]);
            }else{
                return response()->json([
                    'message' => 'The exam is already registered',
                ]);
            }


        }else{
            return response()->json([
                'message' => 'You are not authorized',
            ]);
        }
    }
    public function viewExam($exam_id)
    {
        $student_id = auth()->user()->id;
        $checkEnroll = Enroll::firstWhere('student_id',$student_id)->firstWhere('exam_id',$exam_id);
        if($checkEnroll){
           $exam_id = $checkEnroll->exam_id;
           $exam = Question::where('exam_id',$exam_id)->get();
            return response()->json([
                'message' => 'Test started',
                'exam' => $exam,
            ]);
        }else{
            return response()->json([
                'message' => 'You are not authorized',
            ]);
        }
    }

    public function checkQoustion(Request $request,$question_id)
    {
        $student_id = auth()->user()->id;
        $exam_id = Enroll::firstWhere('student_id',$student_id)->exam_id;
        $question = Question::Where('exam_id',$exam_id)->firstWhere('id',$question_id);
        $Revision =  Revision::firstWhere('student_id',$student_id);
        $Revision_id= 0;
        $answers_correct = 0;
        $answers_wrong = 0;

        if($question){
            ##### Check revision schedule
            if($Revision){
                $Revision_id = $Revision->id;
                $answers_correct = $Revision->answers_correct;
                $answers_wrong = $Revision->answers_wrong;
            }
            ##############################################################
            if($question->question_answer === $request->question_answer){
             $result = Revision::updateOrCreate(
                    ['id' => $Revision_id],
                    [
                        'answers_correct' => $answers_correct + 1,
                        'exam_id' => $question->exam_id,
                        'student_id' => $student_id,
                    ]);
                return response()->json([
                    'message' => 'correct answer',
                    'result' => $result,
                ]);
            }else{
                $result = Revision::updateOrCreate(
                    ['id' => $Revision_id],
                    [
                        'answers_wrong' => $answers_wrong + 1,
                        'exam_id' => $question->exam_id,
                        'student_id' => $student_id,
                    ]
                 );
                return response()->json([
                    'message' => 'answer wrong',
                    'result' => $result,
                ]);
            }
        }else{
                return response()->json([
                     'message' => 'question id is not available',
                     ]);
                 }
    }

}

