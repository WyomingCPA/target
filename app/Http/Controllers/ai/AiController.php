<?php

namespace App\Http\Controllers\ai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function index(Request $request)
    {
        return view('ai.index', []);
    }
    public function plan(Request $request)
    {
        return view('ai.planing', []);
    }
    public function decompositionTask(Request $request)
    {
        return view('ai.decomposition', []);
    }
    public function idea(Request $request)
    {
        return view('ai.idea', []);
    }
}
