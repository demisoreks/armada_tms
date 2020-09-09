<div class="form-group row">
    {!! Form::label('name', 'Name *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Name', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('address', 'Address *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea('address', $value = null, ['class' => 'form-control', 'placeholder' => 'Address', 'required' => true, 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('contact_person', 'Contact Person *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('contact_person', $value = null, ['class' => 'form-control', 'placeholder' => 'Contact Person', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('mobile_no', 'Mobile No. *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::number('mobile_no', $value = null, ['class' => 'form-control', 'placeholder' => 'Mobile No.', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('email', 'Email Address *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::email('email', $value = null, ['class' => 'form-control', 'placeholder' => 'Email Address', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('ers_code_name', 'ERS Code Name', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('ers_code_name', $value = null, ['class' => 'form-control', 'placeholder' => 'ERS Code Name', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
