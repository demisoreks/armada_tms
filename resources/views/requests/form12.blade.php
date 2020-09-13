<div class="form-group row">
    {!! Form::label('evidence', 'You can upload image(s) or short videos as evidence', ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        {!! Form::file('evidence', $value = null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('description', 'Description *', ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        {!! Form::text('description', $value = null, ['class' => 'form-control', 'placeholder' => 'Descrription', 'maxlength' => 200, 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
