<?php

namespace App\Http\Controllers;

class PackagesController extends Controller
{
    public function index()
    {
        $packages = \App\Models\ServicePackage::where('is_active', true)->get();
        return view('packages', compact('packages'));
    }
}
