<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdConfig;
use App\AmdActivity;

class ConfigController extends Controller
{
    public function index() {
        $config = AmdConfig::whereId(1)->first();
        return view('config', compact('config'));
    }
    
    public function update() {
        $input = array_except(Input::all(), '_method');
        $config = AmdConfig::whereId(1)->first();
        if ($config->update($input)) {
            if (!isset($_SESSION)) session_start();
            $halo_user = $_SESSION['halo_user'];
            AmdActivity::create([
                'employee_id' => $halo_user->id,
                'detail' => 'Configuration was updated.',
                'source_ip' => $_SERVER['REMOTE_ADDR']
            ]);
            return Redirect::route('config')
                    ->with('success', '<span class="font-weight-bold">Successful!</span><br />Configuration has been updated.');
        } else {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                    ->withInput();
        }
    }
}
