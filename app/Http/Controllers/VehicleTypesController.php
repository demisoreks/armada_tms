<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdVehicleType;
use App\AmdActivity;
use App\AmdUser;
use App\AmdVehicle;

class VehicleTypesController extends Controller
{
    public function index() {
        $vehicle_types = AmdVehicleType::all();
        return view('vehicle_types.index', compact('vehicle_types'));
    }
    
    public function create() {
        return view('vehicle_types.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $existing_vehicle_types = AmdVehicleType::where('description', $input['description']);
        if ($existing_vehicle_types->count() != 0) {
            $error .= "Vehicle type description already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $vehicle_type = AmdVehicleType::create($input);
            if ($vehicle_type) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Vehicle type was created - '.$vehicle_type->description.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('vehicle_types.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vehicle type has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AmdVehicleType $vehicle_type) {
        return view('vehicle_types.edit', compact('vehicle_type'));
    }
    
    public function update(AmdVehicleType $vehicle_type) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_vehicle_types = AmdVehicleType::where('description', $input['description'])->where('id', '<>', $vehicle_type->id);
        if ($existing_vehicle_types->count() != 0) {
            $error .= "Vehicle type name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($vehicle_type->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Vehicle type was updated - '.$vehicle_type->description.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('vehicle_types.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vehicle type has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AmdVehicleType $vehicle_type) {
        $input['active'] = false;
        $vehicle_type->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Vehicle type was disabled - '.$vehicle_type->description.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('vehicle_types.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vehicle type has been disabled.');
    }
    
    public function enable(AmdVehicleType $vehicle_type) {
        $input['active'] = true;
        $vehicle_type->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Vehicle type was enabled - '.$vehicle_type->description.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('vehicle_types.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vehicle type has been enabled.');
    }
    
    public function get_vehicles(int $vehicle_type_id) {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        return AmdVehicle::where('vehicle_type_id', $vehicle_type_id)->where('region_id', AmdUser::where('employee_id', $halo_user->id)->first()->region_id)->where('active', true)->orderBy('plate_number')->get()->toJson();
    }
}
