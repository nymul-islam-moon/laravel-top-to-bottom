<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('test.index');
    }

    public function submit(Request $request)
    {
        $test = new Test();

        $test->name = $request->name;
        $test->save();

        return back()->with(['error', 'OK']);
    }
}
