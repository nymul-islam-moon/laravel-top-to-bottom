<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        return view('test.index', compact('tests'));
    }

    public function submit(Request $request)
    {
        $test = new Test();

        $test->name = $request->name;
        $test->save();

        return back()->with(['error', 'OK']);
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return back()->with('Success');
    }
}
