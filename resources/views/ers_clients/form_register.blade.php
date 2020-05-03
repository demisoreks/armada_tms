<div class="form-group row">
    {!! Form::label('title', 'Title/Salutation', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::text('title1', $value = null, ['class' => 'form-control', 'placeholder' => 'Title/Salutation', 'maxlength' => 50]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('first_name', 'First Name *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::text('first_name', $value = null, ['class' => 'form-control', 'placeholder' => 'First Name', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('surname', 'Surname *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::text('surname', $value = null, ['class' => 'form-control', 'placeholder' => 'Surname', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('home_address', 'Home Address *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::textarea('home_address', $value = null, ['class' => 'form-control', 'placeholder' => 'Home Address', 'required' => true, 'maxlength' => 500, 'rows' => 4]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('primary_phone', 'Primary Phone *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::number('primary_phone', $value = null, ['class' => 'form-control', 'placeholder' => 'Primary Phone', 'required' => true, 'maxlength' => 11]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('alternate_phone', 'Alternate Phone', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::number('alternate_phone', $value = null, ['class' => 'form-control', 'placeholder' => 'Alternate Phone', 'maxlength' => 11]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('email', 'Email Address *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::email('email', $value = null, ['class' => 'form-control', 'placeholder' => 'Email Address', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('identity', 'Identity Document *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::file('identity', $value = null, ['class' => 'form-control', 'placeholder' => 'Identity Document', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('utility', 'Utility Bill *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::file('utility', $value = null, ['class' => 'form-control', 'placeholder' => 'Utility Bill', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary btn-lg btn-block', 'onClick' => 'return confirmSubmit()']) !!}
    </div>
</div>