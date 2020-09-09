@extends('app', ['page_title' => 'Patrol', 'open_menu' => 'task'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('ers_locations.index') }}"><i class="fas fa-list"></i> Existing ERS Locations</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New ERS Location</legend>
        {!! Form::model(new App\AmdErsLocation, ['route' => ['ers_locations.store'], 'class' => 'form-group']) !!}
            @include('visits/form', ['submit_text' => 'Create ERS Location'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
