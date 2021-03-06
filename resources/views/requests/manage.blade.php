@extends('app', ['page_title' => 'Manage Task', 'open_menu' => 'task'])

<?php
if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
?>
@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('requests.assigned') }}"><i class="fas fa-list"></i> My Tasks</a>
        @if ($request->status->description == "Assigned" || $request->status->description == "Acknowledged")
        <a class="btn btn-success" href="{{ route('requests.start', $request->slug()) }}" onclick="return confirmStart()"><i class="fas fa-check"></i> Start Task</a>
        @elseif ($request->status->description == "Started")
        @if (!($request->service_type == "ER" && (App\AmdIncident::where('request_id', $request->id)->count() == 0 || App\AmdErsVisit::where('request_id', $request->id)->count() == 0)))
        <a class="btn btn-success" href="{{ route('requests.complete', $request->slug()) }}" onclick="return confirmComplete()" title="Complete Task"><i class="fas fa-check"></i> Complete Task</a>
        @endif
        <a class="btn btn-info" data-toggle="modal" data-target="#modal1" title="Situation Report"><i class="fas fa-info"></i> Sitrep</a>
        @if ($request->service_type == "ER")
        <a class="btn btn-danger" data-toggle="modal" data-target="#modal3" title="Incident Report"><i class="fas fa-info"></i> Incident</a>
        @endif
        @endif
        <a class="btn btn-secondary" href="{{ route('requests.jmp', $request->slug()) }}" target="_blank"><i class="fas fa-map"></i> JMP</a>
        <a class="btn btn-blue-grey" href="{{ route('requests.direction', $request->slug()) }}" target="_blank"><i class="fas fa-location-arrow"></i> Direction</a>
    </div>
</div>
@if ($request->service_type == "ER" && App\AmdIncident::where('request_id', $request->id)->count() == 0)
<div class="alert alert-warning">
An ER task can only be completed after an incident has been added and checklist updated.
</div>
@endif
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

        @if ($request->service_type == "SM")

        <legend>Journey Stops</legend>
        @if (App\AmdRequestStop::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdRequestStop::where('request_id', $request->id)->get() as $request_stop)
            <tr>
                <td width="100%">{{ $request_stop->address }}</td>
            </tr>
            @endforeach
        </table>
        @endif

        @endif
    </div>
    <div class="col-lg-6">
        @if ($request->service_type == "ER" && $request->status->description == "Started")

        <legend>Incident(s)</legend>
        @if (App\AmdIncident::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdIncident::where('request_id', $request->id)->get() as $incident)
            <tr>
                <td>{{ $incident->incidentType->description }}</td>
                <td>{{ $incident->description }}</td>
                <td width="100" align="center"><a title="Remove Incident" class="btn btn-danger btn-sm" href="{{ route('requests.remove_incident', $incident->slug()) }}" onclick="return confirmDelete()">Remove</a></td>
            </tr>
            @endforeach
        </table>
        @endif

        <legend>File Upload</legend>
        {!! Form::model(null, ['route' => ['requests.upload_file', $request->slug()], 'class' => 'form-group', 'files' => true]) !!}
        @include('requests/form12', ['submit_text' => 'Update File'])
        {!! Form::close() !!}

        @if (App\AmdErsFile::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdErsFile::where('request_id', $request->id)->get() as $file)
            <tr>
                <td>{{ $file->description }}</td>
                <td width="100" align="center"><a title="View/Download File" class="btn btn-info btn-sm" href="{{ config('app.url') }}{{ Storage::url('public/ers/evidences/'.$file->filename.'.'.$file->extension) }}" target="_blank">View/Download</a></td>
                <td width="100" align="center"><a title="Remove File" class="btn btn-danger btn-sm" href="{{ route('requests.remove_file', $file->slug()) }}" onclick="return confirmDelete()">Remove</a></td>
            </tr>
            @endforeach
        </table>
        @endif

        <?php
        if (App\AmdErsVisit::where('request_id', $request->id)->count() > 0) {
            $visit = App\AmdErsVisit::where('request_id', $request->id)->first();
        }
        ?>

        <legend>Checklist</legend>
        {!! Form::model(null, ['route' => ['requests.update_checklist', $request->slug()], 'class' => 'form-group']) !!}
        @include('requests/form11', ['submit_text' => 'Update Checklist'])
        {!! Form::close() !!}

        @endif

        @if ($request->service_type == "SM")

        <legend>Service Selection</legend>
        @if (App\AmdRequestOption::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdRequestOption::where('request_id', $request->id)->get() as $request_option)
            <tr>
                <td width="60%">{{ App\AmdService::whereId(App\AmdOption::whereId($request_option->option_id)->first()->service_id)->first()->description }} | {{ App\AmdOption::whereId($request_option->option_id)->first()->description }}</td>
                <td>{{ date('M j', strtotime($request_option->start_date)) }} - {{ date('M j', strtotime($request_option->end_date)) }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Requirements</strong><br />
                    @foreach (App\AmdRequirement::where('option_id', $request_option->option_id)->get() as $requirement)
                        @if ($requirement->other_requirement_type == 0)
                            {{ App\AmdVehicleType::whereId($requirement->vehicle_type_id)->first()->description }}
                        @elseif ($requirement->other_requirement_type == 1)
                            Commander
                        @elseif ($requirement->other_requirement_type == 2)
                            Police
                        @endif
                        : {{ $requirement->quantity }}<br />
                    @endforeach
                </td>
            </tr>
            @endforeach
        </table>
        @endif

        <legend>Resources</legend>
        @if (App\AmdResource::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdResource::where('request_id', $request->id)->orderBy('resource_type')->get() as $resource)
            <tr>
                <td>
                     @if ($resource->resource_type == 0)
                     Vehicle ({{ App\AmdVehicle::whereId($resource->resource_id)->first()->plate_number }})
                     @elseif ($resource->resource_type == 1)
                     Commander ({{ App\AmdUser::whereId($resource->resource_id)->first()->name }})
                     @elseif ($resource->resource_type == 2)
                     Police - {{ $resource->quantity }}
                     @endif
                </td>
            </tr>
            @endforeach
        </table>
        @endif

        @endif
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
