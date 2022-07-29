<?php

namespace App\Http\Controllers\Api;
use App\Trainer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        return Trainer::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
        ]);
        $trainer = Trainer::create($request->all());
        return response()->json([
            'message' => 'Added successfully',
            'trainer' => $trainer,
        ]);
    }


    public function show($id)
    {
        return Trainer::findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:20',
        ]);
        $trainer = Trainer::findOrFail($id);
        $trainer->update($request->all());
        return response()->json([
            'message' => 'Edited successfully',
            'trainer' => $trainer,
        ]);
    }

    public function destroy($id)
    {

        $$trainer = Trainer::destroy($id);
        $data['status'] = 'done';
        return response()->json([
            'message' => 'Deleted',
        ]);
    }
}
