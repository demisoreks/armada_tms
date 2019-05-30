<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Input;
use App\AmdActivity;
use App\AmdVehicle;
use App\AmdRegion;

class VehiclesController extends Controller
{
    public function index(AmdRegion $region) {
        $vehicles = AmdVehicle::where('region_id', $region->id)->get();
        return view('vehicles.index', compact('vehicles', 'region'));
    }
    
    public function create(AmdRegion $region) {
        return view('vehicles.create', compact('region'));
    }
    
    public function store(AmdRegion $region) {
        $input = Input::all();
        $error = "";
        $existing_vehicles = AmdVehicle::where('plate_number', $input['plate_number']);
        if ($existing_vehicles->count() != 0) {
            $error .= "Vehicle plate number already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $input['region_id'] = $region->id;
            $vehicle = AmdVehicle::create($input);
            if ($vehicle) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Vehicle was created - '.$vehicle->plate_number.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('regions.vehicles.index', $region->slug())
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vehicle has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AmdRegion $region, AmdVehicle $vehicle) {
        return view('vehicles.edit', compact('region', 'vehicle'));
    }
    
    public function update(AmdRegion $region, AmdVehicle $vehicle) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_vehicles = AmdVehicle::where('plate_number', $input['plate_number'])->where('id', '<>', $vehicle->id);
        if ($existing_vehicles->count() != 0) {
            $error .= "Vehicle plate number already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($vehicle->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Vehicle was updated - '.$vehicle->plate_number.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('regions.vehicles.index', $region->slug())
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vehicle has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AmdRegion $region, AmdVehicle $vehicle) {
        $input['active'] = false;
        $vehicle->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Vehicle was disabled - '.$vehicle->plate_number.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('regions.vehicles.index', $region->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vehicle has been disabled.');
    }
    
    public function enable(AmdRegion $region, AmdVehicle $vehicle) {
        $input['active'] = true;
        $vehicle->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Vehicle was enabled - '.$vehicle->plate_number.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('regions.vehicles.index', $region->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vehicle has been enabled.');
    }
}
