<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function feedback() {
        
        
        return view('analytics.feedback');
    }
}
