@extends('app', ['page_title' => 'Direction', 'open_menu' => 'task'])

<?php
if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
?>
@section('content')
<div class="row">
    <div class="col-lg-6">
        <legend>Direction Details</legend>
        {!! Form::model(null, ['route' => ['patrols.direction', $ers_location->slug()], 'class' => 'form-group']) !!}
            @include('visits/form9', ['submit_text' => 'Get Direction'])
        {!! Form::close() !!}

        @if ($details != null)
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <td><strong>Start Address</strong></td>
                <td>{{ $details->start_address }}</td>
            </tr>
            <tr>
                <td><strong>End Address</strong></td>
                <td>{{ $details->end_address }}</td>
            </tr>
            <tr>
                <td><strong>Distance</strong></td>
                <td>{{ $details->distance->text }}</td>
            </tr>
            <tr>
                <td><strong>Duration</strong></td>
                <td>{{ $details->duration->text }}</td>
            </tr>
            <tr>
                <td colspan="2"><a href="https://google.com/maps/dir/{{ urlencode($start_point) }}/{{ $ers_location->latitude.",".$ers_location->longitude }}" target="_blank" class="btn btn-block btn-blue-grey"><i class="fas fa-location-arrow"></i> Show on map</a></td>
            </tr>
            @foreach ($details->steps as $step)
            <tr>
                <td colspan="2">{!! $step->html_instructions !!}</td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>
    <div class="col-lg-6">
        <legend>Request Details</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="45%" class="font-weight-bold">Client</td>
                <td>{{ $ers_location->client->name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Location</td>
                <td>{{ $ers_location->name }}</td>
            </tr>
        </table>
    </div>
</div>

<div id="map" hidden></div>

<script src="{{ "https://maps.googleapis.com/maps/api/js?key=".App\AmdConfig::whereId(1)->first()->google_places_api_key."&libraries=places&callback=initAutocomplete" }}" async defer></script>
<script>
function initAutocomplete() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -33.8688, lng: 151.2195},
    zoom: 13,
    mapTypeId: 'roadmap'
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('start_point');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
}
</script>
@endsection
