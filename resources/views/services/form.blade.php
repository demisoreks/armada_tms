<div class="form-group row">
    {!! Form::label('description', 'Description *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('description', $value = null, ['class' => 'form-control', 'placeholder' => 'Description', 'required' => true, 'maxlength' => 150]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('offerings', 'Offerings *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea('offerings', $value = null, ['class' => 'form-control', 'placeholder' => 'Offerings', 'required' => true, 'maxlength' => 10000]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>