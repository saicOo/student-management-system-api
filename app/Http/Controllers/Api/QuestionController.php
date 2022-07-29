<?php

namespace App\Http\Controllers\Api;
use App\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_content' => 'required|max:200',
            'question_answer' => 'required|max:100',
            'question_answer_fake1' => 'required|max:100',
            'question_answer_fake2' => 'required|max:100',
            'question_answer_fake3' => 'required|max:100',
            'exam_id' => 'required|exists:exams,id',
        ]);
        $question = new Question;
        $question->question_content = $request->question_content;
        $question->question_answer = $request->question_answer;
        $question->question_answer_fake1 = $request->question_answer_fake1;
        $question->question_answer_fake2 = $request->question_answer_fake2;
        $question->question_answer_fake3 = $request->question_answer_fake3;
        $question->exam_id  = $request->exam_id;
        $question->save();
        return response()->json([
            'message' => 'Question and answers added successfully',
            'question' => $question,
        ]);
    }


    public function show($id)
    {
        return Question::findOrFail($id);
    }
    public function destroy($id)
    {
        $question = Question::destroy($id);
        return response()->json([
            'message' => 'Question and answers removed',
        ]);
    }
}
