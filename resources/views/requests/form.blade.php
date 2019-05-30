<?php
$service_date_time = explode(" ", $request->service_date_time);
if (count($service_date_time) > 1) {
    $request->service_date = $service_date_time[0];
    $request->service_time = $service_date_time[1];
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
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>