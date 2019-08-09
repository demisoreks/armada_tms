<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Input;
use DB;
use App\AmdActivity;
use App\AmdState;

class StatesController extends Controller
{
    public function index() {
        $states = AmdState::all();
        return view('states.index', compact('states'));
    }
    
    public function edit(AmdState $state) {
        return view('states.edit', compact('state'));
    }
    
    public function update(AmdState $state) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        /*$existing_clients = AmdClient::where('email', $input['email'])->where('id', '<>', $client->id);
        if ($existing_clients->count() != 0) {
            $error .= "Client email already exists.<br />";
        }*/
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($state->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'State was updated - '.$state->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('states.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />State has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
}
