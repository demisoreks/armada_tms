<?php
use GuzzleHttp\Client;
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Journey Management Plan | {{ config('app.name') }}</title>
        
        <style type="text/css">
        #map {
          height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
          height: 100%;
          margin: 0;
          padding: 0;
        }
        #description {
          font-family: Roboto;
          font-size: 15px;
          font-weight: 300;
        }

        #infowindow-content .title {
          font-weight: bold;
        }

        #infowindow-content {
          display: none;
        }

        #map #infowindow-content {
          display: inline;
        }

        .pac-card {
          margin: 10px 10px 0 0;
          border-radius: 2px 0 0 2px;
          box-sizing: border-box;
          -moz-box-sizing: border-box;
          outline: none;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
          background-color: #fff;
          font-family: Roboto;
        }

        #pac-container {
          padding-bottom: 12px;
          margin-right: 12px;
        }

        .pac-controls {
          display: inline-block;
          padding: 5px 11px;
        }

        .pac-controls label {
          font-family: Roboto;
          font-size: 13px;
          font-weight: 300;
        }

        #pac-input {
          background-color: #fff;
          font-family: Roboto;
          font-size: 15px;
          font-weight: 300;
          margin-left: 12px;
          padding: 0 11px 0 13px;
          text-overflow: ellipsis;
          width: 400px;
        }

        #pac-input:focus {
          border-color: #4d90fe;
        }

        #title {
          color: #fff;
          background-color: #4d90fe;
          font-size: 25px;
          font-weight: 500;
          padding: 6px 12px;
        }
        #target {
          width: 345px;
        }
        
        .pac-container {
            background-color: #FFF;
            z-index: 100000;
            position: absolute;
            display: inline-block;
            float: left;
        }
        .modal{
            z-index: 2000;
        }
        .modal-backdrop{
            z-index: 1000;
        }​
        </style>
        
        {!! Html::style('css/app.css') !!}
        {!! Html::style('css/mdb.min.css') !!}
        {!! Html::style('css/datatables.min.css') !!}
        {!! Html::style('fontawesome/css/all.css') !!}
        
        {!! Html::script('js/jquery-3.3.1.min.js') !!}
        {!! Html::script('js/popper.min.js') !!}
        {!! Html::script('js/app.js') !!}
        {!! Html::script('js/mdb.min.js') !!}
        {!! Html::script('js/datatables.min.js') !!}
        
        <!-- Styles -->
        
    </head>
    
    <body style="background-color: #fff;">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h2 class="text-center font-weight-bold">Journey Management Plan</h2>
                <table class="table table-bordered">
                    <tr>
                        <td>
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <th colspan="3"><h4 class="font-weight-bold">Commander(s)</h4></th>
                                </tr>
                                @foreach (App\AmdResource::where('request_id', $request->id)->where('resource_type', 1)->get() as $commander)
                                <tr>
                                    <td width="30%">Name</td>
                                    <td width="40%">{{ App\AmdUser::whereId($commander->resource_id)->first()->name }}</td>
                                    <td class="text-center" rowspan="2">@if (File::exists('storage/pictures/'.$commander->resource_id.'.jpg')) {{ Html::image('storage/pictures/'.$commander->resource_id.'.jpg', 'Commander picture', ['height' => '120px', 'class' => 'rounded-circle']) }} @endif</td>
                                </tr>
                                <tr>
                                    <td>Mobile No.</td>
                                    <td>{{ App\AmdUser::whereId($commander->resource_id)->first()->mobile_no }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3"><h4 class="font-weight-bold">Duty Officer</h4></th>
                                </tr>
                                <tr>
                                    <td width="30%">Name</td>
                                    <td width="40%" colspan="2">{{ App\AmdUser::where('employee_id', App\AmdRequestStatus::where('request_id', $request->id)->where('status_id', App\AmdStatus::where('description', 'Assigned')->first()->id)->orderBy('created_at', 'desc')->first()->updated_by)->first()->full_name }}</td>
                                </tr>
                                <tr>
                                    <td>Mobile No.</td>
                                    <td colspan="2">{{ App\AmdUser::where('employee_id', App\AmdRequestStatus::where('request_id', $request->id)->where('status_id', App\AmdStatus::where('description', 'Assigned')->first()->id)->orderBy('created_at', 'desc')->first()->updated_by)->first()->mobile_no }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3"><h4 class="font-weight-bold">Request Details</h4></th>
                                </tr>
                                <tr>
                                    <td>Pickup/Service Date/Time</td>
                                    <td colspan="2">{{ DateTime::createFromFormat('Y-m-d H:i:s', $request->service_date_time)->format('l, F j, Y') }} {{ DateTime::createFromFormat('Y-m-d H:i:s', $request->service_date_time)->format('g:i a') }}</td>
                                </tr>
                                <tr>
                                    <td>Principal's Name</td>
                                    <td colspan="2">{{ $request->principal_name }}</td>
                                </tr>
                                <tr>
                                    <td>Principal's Mobile No.</td>
                                    <td colspan="2">{{ $request->principal_mobile_no }}</td>
                                </tr>
                                <tr>
                                    <td>Principal's Email Address</td>
                                    <td colspan="2">{{ $request->principal_email }}</td>
                                </tr>
                                <tr>
                                    <td>Additional Information</td>
                                    <td colspan="2">{{ $request->additional_information }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3"><h4 class="font-weight-bold">Services</h4></th>
                                </tr>
                                @foreach (App\AmdRequestOption::where('request_id', $request->id)->get() as $request_option)
                                <tr>
                                    <td colspan="2">{{ $request_option->option->service->description }} | {{ $request_option->option->description }}</td>
                                    <td>{{ date('M j', strtotime($request_option->start_date)) }} - {{ date('M j', strtotime($request_option->end_date)) }}</td>
                                </tr>
                                @endforeach
                                @if (App\AmdResource::where('request_id', $request->id)->where('resource_type', '<>', '1')->count() > 0)
                                <tr>
                                    <th colspan="3"><h4 class="font-weight-bold">Assigned Resources</h4></th>
                                </tr>
                                @foreach (App\AmdResource::where('request_id', $request->id)->where('resource_type', '<>', '1')->get() as $resource)
                                <tr>
                                    <td colspan="3">
                                        @if ($resource->resource_type == 0)
                                        {{ App\AmdVehicleType::whereId(App\AmdVehicle::whereId($resource->resource_id)->first()->vehicle_type_id)->first()->description }} ({{ App\AmdVehicle::whereId($resource->resource_id)->first()->plate_number }})
                                        @elseif ($resource->resource_type == 2)
                                        Police - {{ $resource->quantity }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <th colspan="3"><h4 class="font-weight-bold">Route(s)</h4></th>
                                </tr>
                                <tr>
                                    <td>Start</td>
                                    <td>{{ $request->service_location }}</td>
                                    <td class="text-center">
                                        <a target="_blank" class="btn btn-primary" href="https://maps.google.com/?q={{ str_replace("&", "and", str_replace(" ", "+", $request->service_location)) }}"><i class="fas fa-map-marker"></i> View on map</a>
                                    </td>
                                </tr>
                                @foreach (App\AmdRequestStop::where('request_id', $request->id)->get() as $stop)
                                <tr>
                                    <td>Stop</td>
                                    <td>{{ $stop->address }}</td>
                                    <td class="text-center">
                                        <a target="_blank" class="btn btn-primary" href="https://maps.google.com/?q={{ str_replace("&", "and", str_replace(" ", "+", $stop->address)) }}"><i class="fas fa-map-marker"></i> View on map</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>