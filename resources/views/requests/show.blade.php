@extends('app', ['page_title' => 'Service Requests', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('requests.index') }}"><i class="fas fa-list"></i> Initiated Requests</a>
        <a class="btn btn-success" href="{{ route('requests.submit', $request->slug()) }}" onclick="return confirmSubmit()"><i class="fas fa-check"></i> Submit Request</a>
        <a class="btn btn-danger" href="{{ route('requests.cancel', $request->slug()) }}" onclick="return confirmCancel()"><i class="fas fa-trash"></i> Cancel Request</a>
    </div>
</div>
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
        <legend>Request Details <span class="text-right"><a data-toggle="modal" data-target="#modal1" title="Edit Request Details"><i class="fas fa-edit"></i></a></span></legend>
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
                <td class="font-weight-bold">Principal's Name/Code</td>
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
        <legend>Service Selection <span><a data-toggle="modal" data-target="#modal2" title="Add Service"><i class="fas fa-plus"></i></a></span></legend>
        @if (App\AmdRequestOption::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdRequestOption::where('request_id', $request->id)->get() as $request_option)
            <tr>
                <td width="50%">{{ App\AmdService::whereId(App\AmdOption::whereId($request_option->option_id)->first()->service_id)->first()->description }} | {{ App\AmdOption::whereId($request_option->option_id)->first()->description }}</td>
                <td width="30%">{{ date('M j', strtotime($request_option->start_date)) }} - {{ date('M j', strtotime($request_option->end_date)) }}</td>
                <td class="text-center"><a href="{{ route('requests.remove_service', $request_option->slug()) }}" title="Remove Service"><i class="fas fa-trash"></i></a></td>
            </tr>
            @endforeach
        </table>
        @endif

        <legend>Journey Stops <span><a data-toggle="modal" data-target="#modal3" title="Add Stop"><i class="fas fa-plus"></i></a></span></legend>
        @if (App\AmdRequestStop::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdRequestStop::where('request_id', $request->id)->get() as $request_stop)
            <tr>
                <td width="80%">{{ $request_stop->address }}</td>
                <td class="text-center"><a href="{{ route('requests.remove_stop', $request_stop->slug()) }}" title="Remove Stop"><i class="fas fa-trash"></i></a></td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>
</div>

<div id="map" hidden></div>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Edit Request Details</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model($request, ['route' => ['requests.update', $request->slug()], 'class' => 'form-group']) !!}
                @method('PUT')
                @include('requests/form', ['submit_text' => 'Update Request'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Add Service</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['route' => ['requests.add_service', $request->slug()], 'class' => 'form-group']) !!}
                @include('requests/form1', ['submit_text' => 'Add Service'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modal3Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Add Stop</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['route' => ['requests.add_stop', $request->slug()], 'class' => 'form-group']) !!}
                @include('requests/form2', ['submit_text' => 'Add Stop'])
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
  var input = document.getElementById('service_location');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Create the search box and link it to the UI element.
  var input2 = document.getElementById('address');
  var searchBox2 = new google.maps.places.SearchBox(input2);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input2);
}
</script>
@endsection
