<?php

namespace App\Http\Controllers\Api;
use App\Teaching;
use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeachingController extends Controller
{
    public function index()
    {
        return Teaching::with(['course','trainer'])->get();
    }

    public function store(Request $request)
    {

        $request->validate([
            'course_id' => 'required|unique:teachings|exists:courses,id',
            'trainer_id' => 'required|exists:trainers,id',
        ]);
        $teaching =   Teaching::create($request->all());
         return response()->json([
            'message' => 'Added successfully',
            'teaching' => $teaching,
        ]);
    }



    public function show($id)
    {
        return Teaching::with(['course','trainer'])->findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required',
            'trainer_id' => 'required',
        ]);
        $Teaching = Teaching::findOrFail($id);
        $Teaching->update($request->all());
        return response()->json([
            'message' => 'Edited successfully',
        ]);
    }

    public function destroy($id)
    {
        $Teaching = Teaching::destroy($id);
        return response()->json([
            'message' => 'Deleted',
        ]);
    }
}
