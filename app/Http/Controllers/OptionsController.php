<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Input;
use App\AmdActivity;
use App\AmdOption;
use App\AmdService;

class OptionsController extends Controller
{
    public function index(AmdService $service) {
        $options = AmdOption::where('service_id', $service->id)->get();
        return view('options.index', compact('options', 'service'));
    }
    
    public function create(AmdService $service) {
        return view('options.create', compact('service'));
    }
    
    public function store(AmdService $service) {
        $input = Input::all();
        $error = "";
        $existing_options = AmdOption::where('service_id', $service->id)->where('description', $input['description']);
        if ($existing_options->count() != 0) {
            $error .= "Option description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $input['service_id'] = $service->id;
            $option = AmdOption::create($input);
            if ($option) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Option was created - '.$option->description.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('services.options.index', $service->slug())
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Option has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AmdService $service, AmdOption $option) {
        return view('options.edit', compact('service', 'option'));
    }
    
    public function update(AmdService $service, AmdOption $option) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_options = AmdOption::where('service_id', $service->id)->where('description', $input['description'])->where('id', '<>', $option->id);
        if ($existing_options->count() != 0) {
            $error .= "Option description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($option->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Option was updated - '.$option->description.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('services.options.index', $service->slug())
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Option has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AmdService $service, AmdOption $option) {
        $input['active'] = false;
        $option->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Option was disabled - '.$option->plate_number.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('services.options.index', $service->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Option has been disabled.');
    }
    
    public function enable(AmdService $service, AmdOption $option) {
        $input['active'] = true;
        $option->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Option was enabled - '.$option->plate_number.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('services.options.index', $service->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Option has been enabled.');
    }
}
