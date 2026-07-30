<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        return view('datamanagement.data-management');
    }

    public function show(Target $target)
{
    return response()->json($target);
}
}