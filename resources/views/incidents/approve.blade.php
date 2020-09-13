@extends('app', ['page_title' => 'Review', 'open_menu' => 'task'])

<?php
if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
?>
@section('content')
<div class="row">
    <div class="col-lg-6">
        <legend>Client Information</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="45%" class="font-weight-bold">Name</td>
                <td>{{ $request->client->name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Contact Person</td>
                <td>{{ $request->client->contact_person }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Mobile Number</td>
                <td>{{ $request->client->mobile_no }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Email Address</td>
                <td>{{ $request->client->email }}</td>
            </tr>
        </table>
        <legend>Request Details</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="45%" class="font-weight-bold">Service Type</td>
                <td>{{ $request->service_type }}</td>
            </tr>
            <tr>
                <td width="45%" class="font-weight-bold">Pickup/Service Date/Time</td>
                <td>{{ $request->service_date_time }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Pickup/Service Location</td>
                <td>{{ $request->service_location }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Name</td>
                <td>{{ $request->principal_name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Mobile No.</td>
                <td>{{ $request->principal_mobile_no }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Email Address</td>
                <td>{{ $request->principal_email }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Additional Information</td>
                <td>{{ $request->additional_information }}</td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6">
        @if ($request->service_type == "ER")

        <legend>Incident(s)</legend>
        @if (App\AmdIncident::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdIncident::where('request_id', $request->id)->get() as $incident)
            <tr>
                <td>
                    {{ $incident->incidentType->description }} | {{ $incident->incident_date_time }}<br />
                    <strong>Description:</strong> {{ $incident->description }}<br />
                    <strong>Action Taken:</strong> {{ $incident->action_taken }}<br />
                    <strong>Follow-up Action:</strong> {{ $incident->follow_up_action }}<br />
                </td>
            </tr>
            @endforeach
        </table>
        @endif

        <legend>Uploaded Files</legend>
        @if (App\AmdErsFile::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdErsFile::where('request_id', $request->id)->get() as $file)
            <tr>
                <td>{{ $file->description }}</td>
                <td width="100" align="center"><a title="View/Download File" class="btn btn-info btn-sm" href="{{ config('app.url') }}{{ Storage::url('public/ers/evidences/'.$file->filename.'.'.$file->extension) }}" target="_blank">View/Download</a></td>
            </tr>
            @endforeach
        </table>
        @endif

        <legend>Checklist</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td>
                    Entry Time<br />
                    <span class="text-info">{{ App\AmdErsVisit::where('request_id', $request->id)->first()->entry_time }}</span><br />
                </td>
            </tr>
            <tr>
                <td>
                    Exit Time<br />
                    <span class="text-info">{{ App\AmdErsVisit::where('request_id', $request->id)->first()->exit_time }}</span><br />
                </td>
            </tr>
            @foreach (App\AmdErsVisitDetail::where('ers_visit_id', App\AmdErsVisit::where('request_id', $request->id)->first()->id)->get() as $detail)
            <tr>
                <td>
                    {{ $detail->description }}<br />
                    <span class="text-info">{{ $detail->option }}</span><br />
                </td>
            </tr>
            @endforeach
        </table>

        @endif

        {!! Form::model(null, ['route' => ['incidents.submit_approval', $request->slug()], 'class' => 'form-group']) !!}
        @include('incidents/form', ['submit_text' => 'Submit'])
        {!! Form::close() !!}
    </div>
</div>

<div id="map" hidden></div>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Situation Report</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['route' => ['requests.add_sitrep', $request->slug()], 'class' => 'form-group']) !!}
                @include('requests/form5', ['submit_text' => 'Add Report'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Principal's Feedback</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['route' => ['requests.complete', $request->slug()], 'class' => 'form-group']) !!}
                @include('requests/form6', ['submit_text' => 'Complete Task'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modal3Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Incident Report</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['route' => ['requests.add_incident', $request->slug()], 'class' => 'form-group']) !!}
                @include('requests/form10', ['submit_text' => 'Add Incident'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script src="{{ "https://maps.googleapis.com/maps/api/js?key=".App\AmdConfig::whereId(1)->first()->google_places_api_key."&libraries=places&callback=initAutocomplete" }}" async defer></script>
<script>
function initAutocomplete() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -33.8688, lng: 151.2195},
    zoom: 13,
    mapTypeId: 'roadmap'
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('location');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
}
</script>
@endsection
