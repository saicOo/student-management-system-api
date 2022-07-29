<?php

namespace App\Http\Controllers\Api;
use App\Enroll;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnrollController extends Controller
{
    public function index()
    {
        return Enroll::with(['course','student','exam'])->get();

    }
}
