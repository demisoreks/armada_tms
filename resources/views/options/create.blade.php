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
        <legend>New Option</legend>
        {!! Form::model(new App\AmdOption, ['route' => ['services.options.store', $service->slug()], 'class' => 'form-group']) !!}
            @include('options/form', ['submit_text' => 'Create Option'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
