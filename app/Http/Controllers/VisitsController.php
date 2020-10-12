<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use App\AmdClient;
use App\AmdErsLocation;
use App\AmdErsVisit;
use App\AmdErsVisitDetail;
use App\AmdUser;
use App\AmdErsChecklist;
use App\AmdConfig;
use GuzzleHttp\Client;

class VisitsController extends Controller
{
    public function clients() {
        $clients = AmdClient::where('active', true)->get();
        return view('visits.clients', compact('clients'));
    }

    public function locations(AmdClient $client) {
        $ers_locations = AmdErsLocation::where('client_id', $client->id)->where('active', true)->get();
        return view('visits.locations', compact('ers_locations'));
    }

    public function create(AmdErsLocation $ers_location) {
        return view('visits.create', compact('ers_location'));
    }

    public function store(AmdErsLocation $ers_location) {
        $input = Input::all();

        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];

        $visit_input['ers_location_id'] = $ers_location->id;
        $visit_input['user_id'] = AmdUser::where('employee_id', $halo_user->id)->first()->id;
        $visit_input['entry_time'] = $input['entry_time'];
        $visit_input['exit_time'] = $input['exit_time'];
        $visit_input['request_id'] = 0;
        $visit = AmdErsVisit::create($visit_input);

        foreach (AmdErsChecklist::where('patrol', true)->get() as $check) {
            if ($check->clients == null || $check->clients == "" || in_array($ers_location->client_id, explode(',', $check->clients))) {
                if (isset($input[$check->id])) {
                    AmdErsVisitDetail::create([
                        'ers_visit_id' => $visit->id,
                        'description' => $check->description,
                        'option' => $input[$check->id]
                    ]);
                }
            }
        }

        return Redirect::route('visits.locations', $ers_location->client->slug())
                ->with('success', '<span class="font-weight-bold">Done!</span><br />Patrol visit has been added.');
    }

    public function direction(AmdErsLocation $ers_location, Request $req) {
        $input = $req->input();
        $start_point = "";
        $details = null;
        if (isset($input['start_point'])) {
            $start_point = $input['start_point'];

            $client = new Client();
            $response = $client->get('https://maps.googleapis.com/maps/api/directions/json', [
                'query' => [
                    'origin' => $start_point,
                    'destination' => $ers_location->latitude.",".$ers_location->longitude,
                    'key' => AmdConfig::find(1)->google_places_api_key
                ]
            ]);
            $res = json_decode($response->getBody());
            if (isset($res->routes)) {
                $routes = $res->routes;
                if (count($routes) > 0) {
                    $route = $routes[0];
                    $legs = $route->legs;
                    $details = $legs[0];
                }
            }
        } else {
            $start_point = "";
        }

        return view('visits.direction', compact('ers_location', 'start_point', 'details'));
    }
}
