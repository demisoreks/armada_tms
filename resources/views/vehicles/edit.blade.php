@extends('app', ['page_title' => 'Vehicles', 'open_menu' => 'resource'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('regions.vehicles.index', $region->slug()) }}"><i class="fas fa-list"></i> Existing Vehicles</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Vehicle</legend>
        {!! Form::model($vehicle, ['route' => ['regions.vehicles.update', $region->slug(), $vehicle->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('vehicles/form', ['submit_text' => 'Update Vehicle'])
        {!! Form::close() !!}
    </div>
</div>
@endsection