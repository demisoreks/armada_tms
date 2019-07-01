<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Input;
use App\AmdActivity;
use App\AmdDowntime;

class DowntimesController extends Controller
{
    public function index() {
        $downtimes = AmdDowntime::where('end_date_time', '>', date('Y-m-d H:i:s'))->get();
        return view('downtimes.index', compact('downtimes'));
    }
    
    public function create() {
        return view('downtimes.create');
    }
    
    public function store() {
        $input = Input::all();
        if ($input['resource_type'] == 0) {
            $input['resource_id'] = $input['vehicle_id'];
        } else if ($input['resource_type'] == 1) {
            $input['resource_id'] = $input['user_id'];
        } else {
            $input['resource_id'] = 0;
        }
        unset($input['vehicle_id']);
        unset($input['vehicle_type_id']);
        unset($input['user_id']);
        
        $input['start_date_time'] = $input['start_date'].' '.$input['start_time'];
        $input['end_date_time'] = $input['end_date'].' '.$input['end_time'];
        
        unset($input['start_date']);
        unset($input['start_time']);
        unset($input['end_date']);
        unset($input['end_time']);
        
        if ($input['end_date_time'] < $input['start_date_time']) {
            return Redirect::route('downtimes.index')
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />The end cannot come before the start.')
                    ->withInput();
        } else if ($input['end_date_time'] < date("Y-m-d H:i:s")) {
            return Redirect::route('downtimes.index')
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />The specified period has passed.<br />This feature is for future planning.')
                    ->withInput();
        } else {
            $downtime = AmdDowntime::create($input);
            if ($downtime) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Downtime was created.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('downtimes.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Downtime has been created.');
            } else {
                return Redirect::route('downtimes.index')
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function destroy(AmdDowntime $downtime) {
        $downtime->delete();
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Downtime was deleted.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('downtimes.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Downtime has been deleted.');
    }
}
