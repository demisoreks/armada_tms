<div class="form-group row">
    {!! Form::label('service_location', 'Service Location', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::text('service_location', $value = null, ['class' => 'form-control controls', 'placeholder' => 'Service Location (Full Address)', 'required' => true, 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-4">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>