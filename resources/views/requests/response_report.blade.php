<?php
use GuzzleHttp\Client;
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Emergency Response Plan | {{ config('app.name') }}</title>

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
                <h2 class="text-center font-weight-bold">Emergency Response Report</h2>
                <table class="table table-bordered table-hover">
                    <tr>
                        <td width="250"><strong>Client Name</strong></td>
                        <td>{{ $request->client->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Response Location</strong></td>
                        <td>{{ $request->principal_name }}<br />{{ $request->service_location }}</td>
                    </tr>
                    <tr>
                        <td><strong>Response Date/Time</strong></td>
                        <td>{{ Carbon\Carbon::parse($request->service_date_time)->format('l, F j, Y g:i a') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Enrty Date/Time</strong></td>
                        <td>{{ Carbon\Carbon::parse(App\AmdErsVisit::where('request_id', $request->id)->first()->entry_time)->format('l, F j, Y g:i a') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Exit Date/Time</strong></td>
                        <td>{{ Carbon\Carbon::parse(App\AmdErsVisit::where('request_id', $request->id)->first()->exit_time)->format('l, F j, Y g:i a') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Response Officer</strong></td>
                        <td>@if ($request->user_id) {{ App\AmdUser::find($request->user_id)->full_name }} @endif</td>
                    </tr>
                    <tr>
                        <td><strong>Duty Officer</strong></td>
                        <td>@if ($request->detailer_user_id) {{ App\AmdUser::find($request->user_id)->full_name }} @endif</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>INCIDENT(S)</strong></td>
                    </tr>
                    @foreach (App\AmdIncident::where('request_id', $request->id)->get() as $incident)
                    <tr>
                        <td colspan="2">
                            <strong>Incident Type:</strong> {{ $incident->incidentType->description }}<br />
                            <strong>Incident Date/Time:</strong> {{ Carbon\Carbon::parse($incident->incident_date_time)->format('l, F j, Y g:i a') }}<br />
                            <strong>Description:</strong> {{ $incident->description }}<br />
                            <strong>Action Taken:</strong> {{ $incident->action_taken }}<br />
                            <strong>Follow-up Action:</strong> {{ $incident->follow_up_action }}<br />
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><strong>FILE(S)</strong></td>
                    </tr>
                    @foreach (App\AmdErsFile::where('request_id', $request->id)->get() as $file)
                    <tr>
                        <td colspan="2">
                            {{ $file->description }}<br />
                            <i class="fas fa-download"></i> <a title="Download" target="_blank" href="{{ Storage::url('public/ers/evidences/'.$file->filename.'.'.$file->extension) }}">{{ $file->filename.'.'.$file->extension }}</a><br />
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><strong>CHECKLIST</strong></td>
                    </tr>
                    @foreach (App\AmdErsVisitDetail::where('ers_visit_id', App\AmdErsVisit::where('request_id', $request->id)->first()->id)->get() as $detail)
                    <tr>
                        <td><strong>{{ $detail->description }}</strong></td>
                        <td>{{ $detail->option }}</td>
                    </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><strong>DUTY OFFICER'S COMMENT</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $request->detailer_review }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
