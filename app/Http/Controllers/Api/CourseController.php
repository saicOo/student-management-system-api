<?php

namespace App\Http\Controllers\Api;
use App\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return Course::all();
    }

    public function store(Request $request)
    {

        $request->validate([
            'course_name' => 'required|unique:courses|string|max:20|min:2',
            'course_level' => 'required|integer|max:12|min:1',
            'discretion' => 'required|max:200|min:5',
        ]);
        $course = Course::create($request->all());
        return response()->json([
            'message' => 'The course has been successfully added',
            'course' => $course,
        ]);
    }


    public function show($id)
    {
        return Course::findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'course_name' => 'required|unique:courses|string|max:20|min:2',
            'course_level' => 'required|integer|max:12|min:1',
            'discretion' => 'required|max:200|min:5',
        ]);
        $course = Course::findOrFail($id);
        $course->update($request->all());

        return response()->json([
            'message' => 'The course has been modified successfully',
            'course' => $course,
        ]);
    }

    public function destroy($id)
    {

        $course = Course::destroy($id);
        return response()->json([
            'message' => 'The course has been deleted',
        ]);
    }

}
