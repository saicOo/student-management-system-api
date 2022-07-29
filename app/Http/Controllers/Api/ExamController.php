<?php

namespace App\Http\Controllers\Api;
use App\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        return Exam::with('course')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:teachings,course_id',
        ]);
        $exam = Exam::create([
            'course_id'=>$request->course_id,
        ]);
        return response()->json([
            'message' => 'Exam added successfully',
            'exam' => $exam,
        ]);
    }

    public function show($id)
    {
        return Exam::with('course')->findOrFail($id);
    }

    public function destroy($id)
    {
        $exam = Exam::destroy($id);
        return response()->json([
            'message' => 'Exam has been deleted',
        ]);
    }
}
