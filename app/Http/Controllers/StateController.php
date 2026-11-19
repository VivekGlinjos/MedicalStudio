<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = \App\Models\State::paginate(12);
        return view('states.index', compact('states'));
    }
}