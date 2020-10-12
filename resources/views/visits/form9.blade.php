<div class="form-group row">
    {!! Form::label('start_point', 'Start Point *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::text('start_point', $value = $start_point, ['class' => 'form-control controls search', 'placeholder' => 'Start Point', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('destination', 'Destination *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::text('destination', $value = $ers_location->latitude.",".$ers_location->longitude, ['class' => 'form-control', 'placeholder' => 'Destination', 'required' => true, 'readonly' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-4">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
