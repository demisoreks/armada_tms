@extends('app', ['page_title' => 'Vehicle Types', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('vehicle_types.index') }}"><i class="fas fa-list"></i> Existing Vehicle Types</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Vehicle Type</legend>
        {!! Form::model(new App\AmdVehicleType, ['route' => ['vehicle_types.store'], 'class' => 'form-group']) !!}
            @include('vehicle_types/form', ['submit_text' => 'Create Vehicle Type'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
