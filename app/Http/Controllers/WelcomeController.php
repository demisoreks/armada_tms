<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Lava;
use App\PtrProject;
use App\PtrUpdate;

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
}
