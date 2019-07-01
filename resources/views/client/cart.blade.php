@extends('app2', ['page_title' => 'Cart'])

<?php
if (!isset($_SESSION))
if (isset($_SESSION['amd_request'])) {
    $amd_request = json_decode($_SESSION['amd_request']);
} else {
    $amd_request = [];
}
var_dump($_SESSION['amd_request']);exit;
?>
@section('content')
@include('commons.message')
<div class="row">
    <div class="col-lg-6" style="margin: 50px 0;">
        <legend>Request Details <span class="text-right"><a data-toggle="modal" data-target="#modal1" title="Edit Request Details"><i class="fas fa-edit"></i></a></span></legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="45%" class="font-weight-bold">Pickup/Service Date/Time</td>
                <td><?php if (isset($amd_request['service_date_time'])) echo $amd_request['service_date_time']; ?></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Pickup/Service Location</td>
                <td><?php if (isset($amd_request['service_location'])) echo $amd_request['service_location']; ?></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Name</td>
                <td></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Mobile No.</td>
                <td></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Email Address</td>
                <td></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Additional Information</td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6" style="margin: 50px 0;">
        
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
                {!! Form::model(null, ['route' => ['client.update_request'], 'class' => 'form-group']) !!}
                <?php
                if (isset($amd_request['service_date_time'])) {
                    $service_date_time = explode(" ", $amd_request['service_date_time']);
                    if (count($service_date_time) > 1) {
                        $amd_request['service_date'] = $service_date_time[0];
                        $amd_request['service_time'] = $service_date_time[1];
                    }
                }
                ?>
                <div class="form-group row">
                    {!! Form::label('service_date_time', 'Pickup/Service Date/Time', ['class' => 'col-md-4 col-form-label']) !!}
                    <div class="col-md-6">
                        {!! Form::date('service_date', $value = null, ['class' => 'form-control', 'required' => true]) !!}
                        {!! Form::time('service_time', $value = null, ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('service_location', 'Service Location', ['class' => 'col-md-4 col-form-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('service_location', $value = null, ['class' => 'form-control controls search', 'placeholder' => 'Service Location (Full Address)', 'required' => true, 'maxlength' => 1000]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('principal_name', 'Principal\'s Name', ['class' => 'col-md-4 col-form-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('principal_name', $value = null, ['class' => 'form-control', 'placeholder' => 'Principal\'s Name', 'required' => true, 'maxlength' => 100]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('principal_mobile_no', 'Principal\'s Mobile No.', ['class' => 'col-md-4 col-form-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('principal_mobile_no', $value = null, ['class' => 'form-control', 'placeholder' => 'Principal\'s Mobile Number', 'required' => true, 'maxlength' => 100]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('principal_email', 'Principal\'s Email Address', ['class' => 'col-md-4 col-form-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('principal_email', $value = null, ['class' => 'form-control', 'placeholder' => 'Principal\'s Email Address', 'required' => true, 'maxlength' => 100]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('additional_information', 'Additional Information', ['class' => 'col-md-4 col-form-label']) !!}
                    <div class="col-md-6">
                        {!! Form::textarea('additional_information', $value = null, ['class' => 'form-control', 'placeholder' => 'Additional Information', 'required' => true, 'maxlength' => 1000]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10 offset-md-4">
                        {!! Form::submit('Update Request Details', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
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