<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;

class ClientController extends Controller
{
    public function index() {
        return view('client.index');
    }
    
    public function cart() {
        return view('client.cart');
    }
    
    public function update_request() {
        $input = Input::all();
        if (!isset($_SESSION)) session_start();
        if (isset($_SESSION['amd_request'])) {
            $amd_request = json_decode($_SESSION['amd_request']);
        } else {
            $amd_request = [];
        }
        $amd_request['service_date_time'] = $input['service_date'].' '.$input['service_time'];
        $amd_request['service_location'] = $input['service_location'];
        $amd_request['principal_name'] = $input['principal_name'];
        $amd_request['principal_mobile_no'] = $input['principal_mobile_no'];
        $amd_request['principal_email'] = $input['principal_email'];
        $amd_request['additional_information'] = $input['additional_information'];
        $_SESSION['amd_request'] = $amd_request;
        return Redirect::route('client.cart')
                ->with('success', '<span class="font-weight-bold">Done!</span><br />Request details have been updated.');
    }
}
