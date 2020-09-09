<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Input;
use App\AmdActivity;
use App\AmdErsLocation;

class ErsLocationsController extends Controller
{
    public function index() {
        $ers_locations = AmdErsLocation::all();
        return view('ers_locations.index', compact('ers_locations'));
    }

    public function create() {
        return view('ers_locations.create');
    }

    public function store() {
        $input = Input::all();
        $error = "";
        $existing_ers_locations = AmdErsLocation::where('name', $input['name']);
        if ($existing_ers_locations->count() != 0) {
            $error .= "ERS location name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $ers_location = AmdErsLocation::create($input);
            if ($ers_location) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'ERS location was created - '.$ers_location->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('ers_locations.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />ERS location has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }

    public function edit(AmdErsLocation $ers_location) {
        return view('ers_locations.edit', compact('ers_location'));
    }

    public function update(AmdErsLocation $ers_location) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_ers_locations = AmdErsLocation::where('name', $input['name'])->where('id', '<>', $ers_location->id);
        if ($existing_ers_locations->count() != 0) {
            $error .= "ERS location name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($ers_location->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'ERS location was updated - '.$ers_location->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('ers_locations.index', $ers_location->slug())
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />ERS location has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }

    public function disable(AmdErsLocation $ers_location) {
        $input['active'] = false;
        $ers_location->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'ERS location was disabled - '.$ers_location->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('ers_locations.index', $ers_location->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />ERS location has been disabled.');
    }

    public function enable(AmdErsLocation $ers_location) {
        $input['active'] = true;
        $ers_location->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'ERS location was enabled - '.$ers_location->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('ers_locations.index', $ers_location->slug())
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />ERS location has been enabled.');
    }
}
