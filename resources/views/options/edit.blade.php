@extends('app', ['page_title' => 'Service Options', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('services.options.index', $service->slug()) }}"><i class="fas fa-list"></i> Existing Options</a>
        <a class="btn btn-primary" href="{{ route('services.index') }}"><i class="fas fa-arrow-left"></i> Back to Services</a>
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <h4>Service: {{ $service->description }}</h4>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Option</legend>
        {!! Form::model($option, ['route' => ['services.options.update', $service->slug(), $option->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('options/form', ['submit_text' => 'Update Option'])
        {!! Form::close() !!}
    </div>
</div>
@endsection