<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdActivity;
use App\AmdService;
use App\AmdOption;

class ServicesController extends Controller
{
    public function index() {
        $services = AmdService::all();
        return view('services.index', compact('services'));
    }
    
    public function create() {
        return view('services.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $existing_services = AmdService::where('description', $input['description']);
        if ($existing_services->count() != 0) {
            $error .= "Service description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $service = AmdService::create($input);
            if ($service) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Service was created - '.$service->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('services.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Service has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AmdService $service) {
        return view('services.edit', compact('service'));
    }
    
    public function update(AmdService $service) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_services = AmdService::where('description', $input['description'])->where('id', '<>', $service->id);
        if ($existing_services->count() != 0) {
            $error .= "Service description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($service->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Service was updated - '.$service->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('services.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Service has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AmdService $service) {
        $input['active'] = false;
        $service->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Service was disabled - '.$service->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('services.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Service has been disabled.');
    }
    
    public function enable(AmdService $service) {
        $input['active'] = true;
        $service->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Service was enabled - '.$service->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('services.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Service has been enabled.');
    }
    
    public function get_options(int $service_id) {
        return AmdOption::where('service_id', $service_id)->where('active', true)->orderBy('description')->get()->toJson();
    }
}
