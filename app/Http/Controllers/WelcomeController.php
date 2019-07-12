<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Lava;
use App\AmdRegion;


class WelcomeController extends Controller
{
    public function index() {
         return view('index');
    }
    
    static function checkAccess() {
        if (!isset($_SESSION)) session_start();
        if (isset($_SESSION['halo_user'])) {
            return true;
        } else {
            return false;
        }
    }
    
    public function thank_you() {
         return view('thank_you');
    }
    
    public function taskboard(AmdRegion $region) {
        return view('taskboard', compact('region'));
    }
}
