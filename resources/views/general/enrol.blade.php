@extends('general', ['page_title' => 'Emergency Response Service'])

@section('content')
<div class="row">
    <div class="col-xl-8 offset-xl-2">
        <div class="card">
            <div class="card-body">
                <legend>Enrolment Form</legend>
                <div class="alert alert-info">
                    <p>
                        Please provide necessary details and documents.<br />
                        A <strong>valid email address</strong> is required for you to receive your unique access code.<br />
                        A <strong>valid identity document</strong> (Driver's License, International Passport or National ID Card) is required.<br />
                        A <strong>valid utility bill</strong> (less than 3 months) is required for address verification.
                    </p>
                    <p>* compulsory</p>
                </div>
                {!! Form::model(new App\AmdErsClient, ['route' => ['ers.submit'], 'class' => 'form-group', 'files' => true]) !!}
                    @include('ers_clients/form_register', ['submit_text' => 'Submit Enrolment Form'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection