<?php

namespace App\Http\Controllers\Api;
use App\Teaching;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeachingController extends Controller
{
    public function index()
    {
        return Teaching::with(['course','trainer'])->get();
    }

    public function show($id)
    {
        return Teaching::with(['course','trainer'])->findOrFail($id);
    }

}
