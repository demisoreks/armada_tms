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
    {!! Form::label('date_of_birth', 'Date of Birth *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::date('date_of_birth', $value = null, ['class' => 'form-control', 'placeholder' => 'Date of Birth', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('gender', 'Gender *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
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
    {!! Form::label('occupation', 'Occupation *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-8">
        {!! Form::text('occupation', $value = null, ['class' => 'form-control', 'placeholder' => 'Occupation', 'required' => true, 'maxlength' => 100]) !!}
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
        <div class="form-check">
            {!! Form::checkbox('terms', $value = null, false, ['class' => 'form-check-input', 'required' => true]) !!}
            <label for="terms" class="form-check-label">I certify that I have carefully read the <a class="text-danger" data-toggle="modal" data-target="#modal1">Terms and Conditions</a> for this service.</label>
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary btn-lg btn-block', 'onClick' => 'return confirmSubmit()']) !!}
    </div>
</div>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Terms and Conditions</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Your access to and use of the Service is conditioned on your acceptance of compliance with these Terms. These Terms apply to all users, visitors and others who access or use the Service.</p>
                <p>By accessing or using the Service, you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</p>
            </div>
        </div>
    </div>
</div>
