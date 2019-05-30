@extends('app', ['page_title' => 'Vehicles', 'open_menu' => 'resource'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('regions.vehicles.index', $region->slug()) }}"><i class="fas fa-list"></i> Existing Vehicles</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Vehicle</legend>
        {!! Form::model(new App\AmdVehicle, ['route' => ['regions.vehicles.store', $region->slug()], 'class' => 'form-group']) !!}
            @include('vehicles/form', ['submit_text' => 'Create Vehicle'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
