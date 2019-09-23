<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use DateTime;
use Mail;
use App\AmdRequest;
use App\AmdClient;
use App\AmdRequestStatus;
use App\AmdActivity;
use App\AmdRequestOption;
use App\AmdRequestStop;
use App\AmdUser;
use App\AmdResource;
use App\AmdSituationReport;
use App\AmdState;
use App\AmdRegion;
use App\AmdStatus;

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
        
        $status = AmdStatus::where('description', 'Initiated')->first();
        
        $request = AmdRequest::create([
            'client_id' => $client->id,
            'status_id' => $status->id
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => $status->id,
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
        $input['region_id'] = AmdState::whereId($input['state_id'])->first()->region_id;
        unset($input['state_id']);
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
        
        $status = AmdStatus::where('description', 'Submitted')->first();
        
        $request->update([
            'status_id' => $status->id
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => $status->id,
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
        
        $status = AmdStatus::where('description', 'Cancelled')->first();
        
        $request->update([
            'status_id' => $status->id
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => $status->id,
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
        $status = AmdStatus::where('description', 'Submitted')->first();
        $requests = AmdRequest::where('status_id', $status->id)->get();
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
    
    public function transfer(AmdRequest $request) {
        $input = Input::all();
        
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $request->update($input);
        
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'A request from '.$request->client->name.' was transferred to '.AmdRegion::whereId($input['region_id'])->first()->name.' region.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        return Redirect::route('requests.submitted')
                ->with('success', '<span class="font-weight-bold">Completed!</span><br />Request has been transferred.');
    }
    
    public function mark_assigned(AmdRequest $request) {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $status = AmdStatus::where('description', 'Assigned')->first();
        
        $request->update([
            'status_id' => $status->id
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => $status->id,
            'updated_by' => $halo_user->id
        ]);
        
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'A request was assigned for '.$request->client->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        $service_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $request->service_date_time);
        $jmp_link = config('app.url')."/requests/".$request->slug()."/jmp";
        $commanders = AmdResource::where('request_id', $request->id)->where('resource_type', 1)->get();
        $app_link = config('app.url')."/requests/assigned";
        
        foreach ($commanders as $commander) {
            $user = AmdUser::whereId($commander->resource_id)->first();
            
            $assignment_email_data = [
                'name' => $user->name,
                'location' => $request->service_location,
                'date' => $service_date_time->format('l, F j, Y'),
                'time' => $service_date_time->format('g:i a'),
                'app_link' => $app_link
            ];
            
            $recipient = $user->email;
            
            Mail::send('emails.assignment', $assignment_email_data, function ($m) use ($recipient) {
                $m->from('hens@halogen-group.com', 'Armada Halogen');
                $m->to($recipient)->subject('Task Assignment | '. config('app.name'));
            });
        }
        
        if ($request->client->email != null && $request->client->email != "") {
            $assigned_email_data = [
                'name' => $request->client->name,
                'jmp_link' => $jmp_link
            ];

            $client_email = $request->client->email;

            Mail::send('emails.request_assigned', $assigned_email_data, function ($m) use ($client_email) {
                $m->from('hens@halogen-group.com', 'Armada Halogen');
                $m->to($client_email)->subject('Request Update');
            });
        }
        
        if ($request->principal_email != null && $request->principal_email != "") {
            $assigned_email_data_p = [
                'name' => $request->principal_name,
                'jmp_link' => $jmp_link
            ];

            $principal_email = $request->principal_email;

            Mail::send('emails.request_assigned_p', $assigned_email_data_p, function ($m) use ($principal_email) {
                $m->from('hens@halogensecurity.com', 'Armada Halogen');
                $m->to($principal_email)->subject('Request Update');
            });
        }
        
        return Redirect::route('requests.submitted')
                ->with('success', '<span class="font-weight-bold">Completed!</span><br />Request has been assigned.');
    }
    
    public function assigned() {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        $assigned_status = AmdStatus::where('description', 'Assigned')->first();
        $started_status = AmdStatus::where('description', 'Started')->first();
        $acknowledged_status = AmdStatus::where('description', 'Acknowledged')->first();
        $user = AmdUser::where('employee_id', $halo_user->id)->first();
        $request_ids = AmdResource::where('resource_type', 1)->where('resource_id', $user->id)->pluck('request_id')->toArray();
        array_push($request_ids, 0);
        $requests = AmdRequest::whereRaw('id in ('.implode(',', $request_ids).')')->whereRaw('status_id in ('.$assigned_status->id.','.$started_status->id.','.$acknowledged_status->id.')')->get();
        return view('requests.assigned', compact('requests'));
    }
    
    public function jmp(AmdRequest $request) {
        return view('requests.jmp', compact('request'));
    }
    
    public function manage(AmdRequest $request) {
        if ($request->status->description == "Assigned") {
            return Redirect::route('requests.assigned')
                ->with('error', '<span class="font-weight-bold">Oops!</span><br />Request has not been acknowledged yet.');
        }
        return view('requests.manage', compact('request'));
    }
    
    public function start(AmdRequest $request) {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $status = AmdStatus::where('description', 'Started')->first();
        
        $request->update([
            'status_id' => $status->id
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => $status->id,
            'updated_by' => $halo_user->id
        ]);
        
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'A request was started for '.$request->client->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        return Redirect::route('requests.manage', $request->slug())
                ->with('success', '<span class="font-weight-bold">Completed!</span><br />Task has been started.');
    }
    
    public function complete(AmdRequest $request) {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $input = Input::all();
        if ($input['interested'] == "Yes") {
            $request->update([
                'rating' => $input['rating'],
                'feedback' => $input['feedback']
            ]);
            
            $completed_email_data = [
                'name' => $request->client->name,
                'principal_name' => $request->principal_name,
                'rating' => $input['rating'],
                'feedback' => $input['feedback']
            ];

            $client_email = $request->client->email;

            Mail::send('emails.request_completed', $completed_email_data, function ($m) use ($client_email) {
                $m->from('hens@halogensecurity.com', 'Armada Halogen');
                $m->to($client_email)->subject('Task Completed');
            });

            $completed_email_data_p = [
                'name' => $request->principal_name,
                'rating' => $input['rating'],
                'feedback' => $input['feedback']
            ];

            $principal_email = $request->principal_email;

            Mail::send('emails.request_completed_p', $completed_email_data_p, function ($m) use ($principal_email) {
                $m->from('hens@halogensecurity.com', 'Armada Halogen');
                $m->to($principal_email)->subject('Task Completed');
            });
        } else {
            $feedback_link = config('app.url')."/requests/".$request->slug()."/feedback";
            
            $completed_email_data = [
                'name' => $request->client->name,
                'feedback_link' => $feedback_link
            ];

            $client_email = $request->client->email;

            Mail::send('emails.request_completed_feedback', $completed_email_data, function ($m) use ($client_email) {
                $m->from('hens@halogensecurity.com', 'Armada Halogen');
                $m->to($client_email)->subject('Task Completed | Feedback Required');
            });

            $completed_email_data_p = [
                'name' => $request->principal_name,
                'feedback_link' => $feedback_link
            ];

            $principal_email = $request->principal_email;

            Mail::send('emails.request_completed_p_feedback', $completed_email_data_p, function ($m) use ($principal_email) {
                $m->from('hens@halogensecurity.com', 'Halogen e-Notification Service');
                $m->to($principal_email)->subject('Task Completed | Feedback Required');
            });
        }
        
        $status = AmdStatus::where('description', 'Completed')->first();
        
        $request->update([
            'status_id' => $status->id
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => $status->id,
            'updated_by' => $halo_user->id
        ]);
        
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'A request was completed for '.$request->client->name.'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        return Redirect::route('requests.assigned')
                ->with('success', '<span class="font-weight-bold">Completed!</span><br />Task has been marked as completed.');
    }
    
    public function add_sitrep(AmdRequest $request) {
        $input = Input::all();
        
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $input['request_id'] = $request->id;
        $input['user_id'] = AmdUser::where('employee_id', $halo_user->id)->first()->id;
        
        AmdSituationReport::create($input);
        return Redirect::route('requests.manage', $request->slug())
                ->with('success', '<span class="font-weight-bold">Done!</span><br />Situation report has been added.');
    }
    
    public function feedback(AmdRequest $request) {
        return view('requests.feedback', compact('request'));
    }
    
    public function submit_feedback(AmdRequest $request) {
        $input = Input::all();
        
        $request->update([
            'rating' => $input['rating'],
            'feedback' => $input['feedback']
        ]);
        
        return Redirect('thank_you');
    }
    
    public function acknowledge(AmdRequest $request) {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        
        $status = AmdStatus::where('description', 'Acknowledged')->first();
        
        $request->update([
            'status_id' => $status->id
        ]);
        AmdRequestStatus::create([
            'request_id' => $request->id,
            'status_id' => $status->id,
            'updated_by' => $halo_user->id
        ]);
        
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'A request was acknowledged for '.$request->client->name.' by '.$halo_user['username'].'.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        return Redirect::route('requests.assigned')
                ->with('success', '<span class="font-weight-bold">Completed!</span><br />Request has been acknowledged.');
    }
}
