<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Lava;
use App\AmdRegion;
use App\AmdStatus;
use App\AmdRequest;

use App\Charts\StatusChart;

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
        $status_chart = new StatusChart();
        
        $status_labels = [];
        $status_counts = [];
        $status_colors = [];
        $i = 0;
        foreach (AmdStatus::whereIn('description', ['Submitted', 'Assigned', 'Acknowledged', 'Started'])->get() as $status) {
            $status_labels[$i] = $status->description;
            $status_counts[$i] = AmdRequest::where('region_id', $region->id)->where('status_id', $status->id)->count();
            if ($status->description == 'Submitted') {
                $status_colors[$i] = '#d9534f';
            } else if ($status->description == 'Assigned') {
                $status_colors[$i] = '#f0ad4e';
            } else if ($status->description == 'Acknowledged') {
                $status_colors[$i] = '#5bc0de';
            } else if ($status->description == 'Started') {
                $status_colors[$i] = '#5cb85c';
            } else {
                $status_colors[$i] = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            }
            $i ++;
        }
        $status_chart->labels($status_labels);
        $status_chart->dataset('Status Distribution', 'doughnut', $status_counts)->backgroundColor($status_colors);
        
        return view('taskboard', compact('region', 'status_chart'));
    }
}
