<?php

namespace App\Http\Controllers\Admin;

use App\Models\Day;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function index()
    {
        $days= Day::all();
        return view('admin.days.index',compact('days'));
    }
}
