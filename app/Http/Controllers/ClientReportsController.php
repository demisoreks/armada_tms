<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use App\AmdClient;
use App\AmdErsLocation;
use App\AmdErsVisit;
use App\AmdRequest;
use App\AmdStatus;

class ClientReportsController extends Controller
{
    public function responses(AmdClient $client) {
        $input = Input::all();
        if (isset($input['from_date']) && isset($input['to_date'])) {
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
        } else {
            $to_date = date("Y-m-d");
            $from_date = date("Y-m-d", strtotime('-7 days', strtotime($to_date)));
        }
        $param = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];

        $requests = AmdRequest::where('service_date_time', '>=', $from_date.' 00:00:00')->where('service_date_time', '<=', $to_date.' 23:59:59')->where('client_id', $client->id)->where('service_type', 'ER')->where('status_id', AmdStatus::where('description', 'Completed')->first()->id)->get();

        return view('client_reports.responses', compact('param', 'requests', 'client'));
    }

    public function patrols(AmdClient $client) {
        $input = Input::all();
        if (isset($input['from_date']) && isset($input['to_date'])) {
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
        } else {
            $to_date = date("Y-m-d");
            $from_date = date("Y-m-d", strtotime('-7 days', strtotime($to_date)));
        }
        $param = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];

        $visits = AmdErsVisit::where('entry_time', '>=', $from_date.' 00:00:00')->where('entry_time', '<=', $to_date.' 23:59:59')->where('request_id', 0)->whereIn('ers_location_id', AmdErsLocation::where('client_id', $client->id)->pluck('id')->toArray())->get();

        return view('client_reports.patrols', compact('param', 'visits', 'client'));
    }

    public function responses_special(AmdClient $client) {
        $input = Input::all();
        if (isset($input['from_date']) && isset($input['to_date'])) {
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
        } else {
            $to_date = date("Y-m-d");
            $from_date = date("Y-m-d", strtotime('-7 days', strtotime($to_date)));
        }
        $param = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];

        $requests = AmdRequest::where('service_date_time', '>=', $from_date.' 00:00:00')->where('service_date_time', '<=', $to_date.' 23:59:59')->where('client_id', $client->id)->where('service_type', 'ER')->where('status_id', AmdStatus::where('description', 'Completed')->first()->id)->get();

        return view('client_reports.responses_special', compact('param', 'requests', 'client'));
    }

    public function patrols_special(AmdClient $client) {
        $input = Input::all();
        if (isset($input['from_date']) && isset($input['to_date'])) {
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
        } else {
            $to_date = date("Y-m-d");
            $from_date = date("Y-m-d", strtotime('-7 days', strtotime($to_date)));
        }
        $param = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];

        $visits = AmdErsVisit::where('entry_time', '>=', $from_date.' 00:00:00')->where('entry_time', '<=', $to_date.' 23:59:59')->where('request_id', 0)->whereIn('ers_location_id', AmdErsLocation::where('client_id', $client->id)->pluck('id')->toArray())->get();

        return view('client_reports.patrols_special', compact('param', 'visits', 'client'));
    }
}
