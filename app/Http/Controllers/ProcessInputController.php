<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProcessInputController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Main');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'input' => ['required', 'max:5'],
        ]);

        $input = $request->input;

        return Inertia::render('Main', ['formData' => $input]);
    }
}
