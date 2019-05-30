<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdActivity;
use App\AmdClient;

class ClientsController extends Controller
{
    public function index() {
        $clients = AmdClient::all();
        return view('clients.index', compact('clients'));
    }
    
    public function create() {
        return view('clients.create');
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        $existing_clients = AmdClient::where('email', $input['email']);
        if ($existing_clients->count() != 0) {
            $error .= "Client email already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $client = AmdClient::create($input);
            if ($client) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Client was created - '.$client->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('clients.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Client has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(AmdClient $client) {
        return view('clients.edit', compact('client'));
    }
    
    public function update(AmdClient $client) {
        $input = array_except(Input::all(), '_method');
        $error = "";
        $existing_clients = AmdClient::where('email', $input['email'])->where('id', '<>', $client->id);
        if ($existing_clients->count() != 0) {
            $error .= "Client email already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            if ($client->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Client was updated - '.$client->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('clients.index')
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Client has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function disable(AmdClient $client) {
        $input['active'] = false;
        $client->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Client was disabled - '.$client->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('clients.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Client has been disabled.');
    }
    
    public function enable(AmdClient $client) {
        $input['active'] = true;
        $client->update($input);
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Client was enabled - '.$client->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('clients.index')
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Client has been enabled.');
    }
}
