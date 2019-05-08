<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdRegion;
use App\AmdActivity;

class RegionsController extends Controller
{
    public function index() {
        $regions = AmdRegion::all();
        return view('regions.index', compact('regions'));
    }
    
    public function create() {
        return view('regions.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $existing_regions = AmdRegion::where('name', $input['name']);
        if ($existing_regions->count() != 0) {
            $error .= "Region name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $region = AmdRegion::create($input);
            if ($region) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Region was created - '.$region->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('regions.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Region has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AmdRegion $region) {
        return view('regions.edit', compact('region'));
    }
    
    public function update(AmdRegion $region) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_regions = AmdRegion::where('name', $input['name'])->where('id', '<>', $region->id);
        if ($existing_regions->count() != 0) {
            $error .= "Region name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($region->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Region was updated - '.$region->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('regions.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Region has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AmdRegion $region) {
        $input['active'] = false;
        $region->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Region was disabled - '.$region->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('regions.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Region has been disabled.');
    }
    
    public function enable(AmdRegion $region) {
        $input['active'] = true;
        $region->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Region was enabled - '.$region->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('regions.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Region has been enabled.');
    }
}
