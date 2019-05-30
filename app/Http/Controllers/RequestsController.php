<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdRequest;
use App\AmdClient;
use App\AmdRequestStatus;
use App\AmdActivity;
use App\AmdRequestOption;
use App\AmdRequestStop;
use App\AmdUser;
use App\AmdResource;

class RequestsController extends Controller
{
    public function index() {
        $requests = AmdRequest::where('status_id', 1)->get();
        return view('requests.index', compact('requests'));
    }
    
    public function create() {
        return view('requests.create');
    }
    
    public function initiate(AmdClient $client) {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $request = AmdRequest::create([
            'client_id' => $client->id,
            'status_id' => 1
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => 1,
            'updated_by' => $halo_user->id
        ]);
        
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'A request was initiated for '.$request->client->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        return Redirect::route('requests.show', $request->slug());
    }
    
    public function show(AmdRequest $request) {
        return view('requests.show', compact('request'));
    }
    
    public function update(AmdRequest $request) {
        $input = array_except(Input::all(), '_method');
        $input['service_date_time'] = $input['service_date'].' '.$input['service_time'];
        unset($input['service_date']);
        unset($input['service_time']);
        $request->update($input);
        return Redirect::route('requests.show', $request->slug())
                ->with('success', '<span class="font-weight-bold">Done!</span><br />Request details have been updated.');
    }
    
    public function add_service(AmdRequest $request) {
        $input = Input::all();
        unset($input['service_id']);
        $input['request_id'] = $request->id;
        if (AmdRequestOption::where('request_id', $input['request_id'])->where('option_id', $input['option_id'])->count() > 0) {
            return Redirect::route('requests.show', $request->slug())
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />Service option has been selected already.');
        } else {
            AmdRequestOption::create($input);
            return Redirect::route('requests.show', $request->slug())
                    ->with('success', '<span class="font-weight-bold">Done!</span><br />Service option has been added.');
        }
    }
    
    public function remove_service(AmdRequestOption $request_option) {
        $request = AmdRequest::whereId($request_option->request_id)->first();
        $request_option->delete();
        return Redirect::route('requests.show', $request->slug())
                ->with('success', '<span class="font-weight-bold">Done!</span><br />Service option has been removed.');
    }
    
    public function add_stop(AmdRequest $request) {
        $input = Input::all();
        $input['request_id'] = $request->id;
        if (AmdRequestStop::where('request_id', $input['request_id'])->where('address', $input['address'])->count() > 0) {
            return Redirect::route('requests.show', $request->slug())
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />Stop address has been added already.');
        } else {
            AmdRequestStop::create($input);
            return Redirect::route('requests.show', $request->slug())
                    ->with('success', '<span class="font-weight-bold">Done!</span><br />Stop has been added.');
        }
    }
    
    public function remove_stop(AmdRequestStop $request_stop) {
        $request = AmdRequest::whereId($request_stop->request_id)->first();
        $request_stop->delete();
        return Redirect::route('requests.show', $request->slug())
                ->with('success', '<span class="font-weight-bold">Done!</span><br />Stop has been removed.');
    }
    
    public function submit(AmdRequest $request) {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $request->update([
            'status_id' => 2
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => 2,
            'updated_by' => $halo_user->id
        ]);
        
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'A request was submitted for '.$request->client->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        return Redirect::route('requests.index')
                ->with('success', '<span class="font-weight-bold">Completed!</span><br />Request has been submitted.');
    }
    
    public function cancel(AmdRequest $request) {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $request->update([
            'status_id' => 7
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => 7,
            'updated_by' => $halo_user->id
        ]);
        
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'A request was cancelled for '.$request->client->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        return Redirect::route('requests.index')
                ->with('success', '<span class="font-weight-bold">Completed!</span><br />Request has been cancelled.');
    }
    
    public function submitted() {
        $requests = AmdRequest::where('status_id', 2)->get();
        return view('requests.submitted', compact('requests'));
    }
    
    public function treat(AmdRequest $request) {
        if ($request->region_id == null) {
            if (!isset($_SESSION)) session_start();
            $halo_user = $_SESSION['halo_user'];
            $request->update(['region_id' => AmdUser::where('employee_id', $halo_user->id)->first()->region_id]);
        }
        return view('requests.treat', compact('request'));
    }
    
    public function add_resource(AmdRequest $request) {
        $input = Input::all();
        $input['request_id'] = $request->id;
        if ($input['resource_type'] == 0) {
            $input['resource_id'] = $input['vehicle_id'];
            $input['quantity'] = 0;
        } else if ($input['resource_type'] == 1) {
            $input['resource_id'] = $input['user_id'];
            $input['quantity'] = 0;
        } else if ($input['resource_type'] == 2) {
            $input['resource_id'] = 0;
        }
        unset($input['vehicle_type_id']);
        unset($input['vehicle_id']);
        unset($input['user_id']);
        if (AmdResource::where('request_id', $input['request_id'])->where('resource_type', $input['resource_type'])->where('resource_id', $input['resource_id'])->count() > 0) {
            return Redirect::route('requests.treat', $request->slug())
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />Resource has been added already.');
        } else {
            AmdResource::create($input);
            return Redirect::route('requests.treat', $request->slug())
                    ->with('success', '<span class="font-weight-bold">Done!</span><br />Resource has been added.');
        }
    }
    
    public function remove_resource(AmdResource $resource) {
        $request = AmdRequest::whereId($resource->request_id)->first();
        $resource->delete();
        return Redirect::route('requests.treat', $request->slug())
                ->with('success', '<span class="font-weight-bold">Done!</span><br />Resource has been removed.');
    }
}
