<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function summary()
    {
        return view('about.summary');
    }

    public function visionMission()
    {
        return view('about.vision_mission');
    }
}
