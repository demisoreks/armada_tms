@extends('general', ['page_title' => 'Emergency Response Service'])

@section('content')
<div class="row">
    <div class="col-xl-8 offset-xl-2">
        <div class="card">
            <div class="card-body">
                <legend>Success!!!</legend>
                <div class="alert alert-info">
                    <p>Dear {{ $client->title }} {{ $client->first_name }} {{ $client->surname }},</p>
                    <p>Thank you for enroling for this service. An email containing your unique access code will be sent to {{ $client->email }}.</p>
                    <p><a href="https://halogen-group.com/" target="_blank">Halogen Group</a></p>
                </div>
                <a href="{{ route('ers.enrol') }}" class="btn btn-block btn-secondary btn-lg">Click here for a new enrolment</a>
            </div>
        </div>
    </div>
</div>
@endsection
