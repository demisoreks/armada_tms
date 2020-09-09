@extends('app', ['page_title' => 'ERS Locations', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('ers_locations.index') }}"><i class="fas fa-list"></i> Existing ERS Locations</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit ERS Location</legend>
        {!! Form::model($ers_location, ['route' => ['ers_locations.update', $ers_location->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('ers_locations/form', ['submit_text' => 'Update ERS Location'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
