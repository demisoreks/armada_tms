@extends('app', ['page_title' => 'Patrol', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('visits.clients') }}"><i class="fas fa-arrow-left"></i> Back to Clients</a>
        <a class="btn btn-blue-grey" href="{{ route('patrols.direction', $ers_location->slug()) }}" target="_blank"><i class="fas fa-location-arrow"></i> Direction</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="alert alert-info">
            <strong>Client:</strong> {{ $ers_location->client->name }}<br />
            <strong>Location:</strong> {{ $ers_location->name }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <legend>New Visit</legend>
        {!! Form::model(null, ['route' => ['visits.store', $ers_location->slug()], 'class' => 'form-group']) !!}
            @include('visits/form', ['submit_text' => 'Submit'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
