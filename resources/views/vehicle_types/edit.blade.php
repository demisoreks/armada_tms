@extends('app', ['page_title' => 'Vehicle Types', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('vehicle_types.index') }}"><i class="fas fa-list"></i> Existing Vehicle Types</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Vehicle Type</legend>
        {!! Form::model($vehicle_type, ['route' => ['vehicle_types.update', $vehicle_type->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('vehicle_types/form', ['submit_text' => 'Update Vehicle Type'])
        {!! Form::close() !!}
    </div>
</div>
@endsection