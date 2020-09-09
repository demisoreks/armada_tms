<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdIncident;
use App\AmdRequest;
use App\AmdUser;
use App\AmdStatus;

class IncidentsController extends Controller
{
    public function review() {
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        $user = AmdUser::where('employee_id', $halo_user->id)->first();
        $completed_status = AmdStatus::where('description', 'Completed')->first()->id;
        $requests = AmdRequest::where('region_id', $user->region_id)->where('status_id', $completed_status)->where('detailer_user_id', null)->where('service_type', 'ER')->get();
        return view('incidents.review', compact('requests'));
    }

    public function approve(AmdRequest $request) {
        return view('incidents.approve', compact('request'));
    }

    public function submit_approval(AmdRequest $request) {
        $input = Input::all();
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        $user = AmdUser::where('employee_id', $halo_user->id)->first();
        $input['detailer_user_id'] = $user->id;
        $request->update($input);
        return Redirect::route('incidents.review', $request->slug())
                ->with('success', '<span class="font-weight-bold">Done!</span><br />Incident review has been completed.');
    }
}
