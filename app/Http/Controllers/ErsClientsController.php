<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Image;
use Storage;
use Mail;
use App\AmdErsClient;
use Carbon\Carbon;

class ErsClientsController extends Controller
{
    public function enrol() {
        return view('general.enrol');
    }
    
    public function submit() {
        $input = Input::all();
        $error = "";
        $existing_clients = AmdErsClient::where('email', $input['email'])->whereIn('status', ['Pending', 'Activated']);
        if ($existing_clients->count() != 0) {
            $error .= "An earlier submission was made with the specified email address.<br />";
        }
        if (Input::hasFile('identity')) {
            if (!in_array(Input::file('identity')->getClientOriginalExtension(), ['jpg', 'pdf'])) {
                $error .= "Invalid file type for identity document. Only JPG and PDF files are allowed.<br />";
            }
            if (Input::file('identity')->getSize() > 2000000) {
                $error .= "File too large for identity document. File must be less than 2MB.<br />";
            }
        }
        if (Input::hasFile('utility')) {
            if (!in_array(Input::file('utility')->getClientOriginalExtension(), ['jpg', 'pdf'])) {
                $error .= "Invalid file type for utility bill. Only JPG and PDF files are allowed.<br />";
            }
            if (Input::file('utility')->getSize() > 2000000) {
                $error .= "File too large for utility bill. File must be less than 2MB.<br />";
            }
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Sorry, we could not submit your data!</span><br />'.$error)
                    ->withInput();
        } else {
            unset($input['identity']);
            unset($input['utility']);
            $input['title'] = strtoupper($input['title1']);
            unset($input['title1']);
            $input['first_name'] = strtoupper($input['first_name']);
            $input['surname'] = strtoupper($input['surname']);
            $input['status'] = "Pending";
            $client = AmdErsClient::create($input);
            if ($client) {
                Storage::put('public/ers/identity/'.$client->id.'.'.Input::file('identity')->getClientOriginalExtension(), file_get_contents(Input::file('identity')->getRealPath()));
                Storage::put('public/ers/utility/'.$client->id.'.'.Input::file('utility')->getClientOriginalExtension(), file_get_contents(Input::file('utility')->getRealPath()));
                return view('general.submit', compact('client'));
            } else {
                return Redirect::back()
                        ->with('error', '<span class="font-weight-bold">Sorry, we could not submit your data!</span><br />Please visit our website for more information.')
                        ->withInput();
            }
        }
    }
    
    public function pending() {
        $clients = AmdErsClient::where('status', 'Pending')->get();
        return view('ers_clients.pending', compact('clients'));
    }
    
    public function active() {
        $clients = AmdErsClient::where('status', 'Active')->get();
        return view('ers_clients.active', compact('clients'));
    }
    
    public function view(AmdErsClient $ers_client) {
        return view('ers_clients.view', compact('ers_client'));
    }
    
    public function generateAccessCode() {
        $alphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numbers = "01234567890123456789";
        
        $access_code = substr(str_shuffle($alphabets), 0, 2).substr(str_shuffle($numbers), 0, 4);
        
        if (AmdErsClient::where('access_code', $access_code)->count() > 0) {
            return generateAccessCode();
        } else {
            return $access_code;
        }
    }


    public function treat(AmdErsClient $ers_client) {
        $input = Input::all();
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        $input['treated_at'] = Carbon::now();
        $input['treated_by'] = $halo_user->id;
        $input['access_code'] = $this->generateAccessCode();
        
        $ers_client->update($input);
        
        $client_name = $ers_client->first_name.' '.$ers_client->surname;
        if ($ers_client->title) {
            $client_name = $ers_client->title.' '.$client_name;
        }
        
        $completed_email_data = [
            'name' => $client_name,
            'access_code' => $input['access_code']
        ];

        $client_email = $ers_client->email;

        Mail::send('emails.ers_access_code', $completed_email_data, function ($m) use ($client_email) {
            $m->from('hens@halogensecurity.com', 'HalogenGroup');
            $m->to($client_email)->subject('Access Code | Emergency Response Service');
        });
        
        return Redirect::route('ers_clients.view', [$ers_client->slug()])
                ->with('success', '<span class="font-weight-bold">Completed!</span><br />You have successfully treated the pending request.');
    }
}
