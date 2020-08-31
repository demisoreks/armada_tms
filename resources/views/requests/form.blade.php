<?php
$service_date_time = explode(" ", $request->service_date_time);
if (count($service_date_time) > 1) {
    $request->service_date = $service_date_time[0];
    $request->service_time = $service_date_time[1];
}
?>
<div class="form-group row">
    {!! Form::label('service_type', 'Service Type *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::select('service_type', ['SM' => 'SM - Secured Mobility', 'ER' => 'ER - Emergency Response'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Service Type -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('service_date_time', 'Pickup/Service Date/Time *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::date('service_date', $value = null, ['class' => 'form-control', 'required' => true]) !!}
        {!! Form::time('service_time', $value = null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('service_location', 'Service Location *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::text('service_location', $value = null, ['class' => 'form-control controls search', 'placeholder' => 'Full Address or Coordinates (Latitude,Longitude)', 'required' => true, 'maxlength' => 1000]) !!}
        {!! Form::select('state_id', App\AmdState::where('active', true)->orderBy('name')->pluck('name', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select State -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row principal_details">
    {!! Form::label('principal_name', 'Principal\'s Name/Code', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::text('principal_name', $value = null, ['class' => 'form-control', 'placeholder' => 'Principal\'s Name/Code', 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row principal_details">
    {!! Form::label('principal_mobile_no', 'Principal\'s Mobile No.', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::number('principal_mobile_no', $value = null, ['class' => 'form-control', 'placeholder' => 'Principal\'s Mobile Number', 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row principal_details">
    {!! Form::label('principal_email', 'Principal\'s Email Address', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::email('principal_email', $value = null, ['class' => 'form-control', 'placeholder' => 'Principal\'s Email Address', 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('additional_information', 'Additional Information', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('additional_information', $value = null, ['class' => 'form-control', 'placeholder' => 'Additional Information, e.g., flight details, special requests, etc.', 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-4">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#service_type').change(function() {
            if ($(this).val() == "ER") {
                //$('.principal_details').slideUp(1000);
            } else {
                //$('.principal_details').slideDown(1000);
            }
        });
    });
</script>
