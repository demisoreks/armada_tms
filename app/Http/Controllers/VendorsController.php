<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdActivity;
use App\AmdVendor;

class VendorsController extends Controller
{
    public function index() {
        $vendors = AmdVendor::all();
        return view('vendors.index', compact('vendors'));
    }
    
    public function create() {
        return view('vendors.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $existing_vendors = AmdVendor::where('name', $input['name']);
        if ($existing_vendors->count() != 0) {
            $error .= "Vendor name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $vendor = AmdVendor::create($input);
            if ($vendor) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Vendor was created - '.$vendor->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('vendors.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vendor has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AmdVendor $vendor) {
        return view('vendors.edit', compact('vendor'));
    }
    
    public function update(AmdVendor $vendor) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_vendors = AmdVendor::where('name', $input['name'])->where('id', '<>', $vendor->id);
        if ($existing_vendors->count() != 0) {
            $error .= "Vendor name already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($vendor->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Vendor was updated - '.$vendor->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('vendors.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vendor has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AmdVendor $vendor) {
        $input['active'] = false;
        $vendor->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Vendor was disabled - '.$vendor->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('vendors.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vendor has been disabled.');
    }
    
    public function enable(AmdVendor $vendor) {
        $input['active'] = true;
        $vendor->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Vendor was enabled - '.$vendor->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('vendors.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Vendor has been enabled.');
    }
}
