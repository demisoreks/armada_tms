@extends('app', ['page_title' => 'Services', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('services.index') }}"><i class="fas fa-list"></i> Existing Services</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Service</legend>
        {!! Form::model($service, ['route' => ['services.update', $service->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('services/form', ['submit_text' => 'Update Service'])
        {!! Form::close() !!}
    </div>
</div>
@endsection