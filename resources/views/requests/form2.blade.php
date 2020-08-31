<div class="form-group row">
    {!! Form::label('address', 'Address *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::text('address', $value = null, ['class' => 'form-control controls search', 'placeholder' => 'Full Address or Coordinates (Latitude,Longitude)', 'required' => true, 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-4">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
