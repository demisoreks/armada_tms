@extends('app', ['page_title' => 'Requirements', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('services.options.requirements.index', [$service->slug(), $option->slug()]) }}"><i class="fas fa-list"></i> Existing Requirements</a>
        <a class="btn btn-primary" href="{{ route('services.options.index', $service->slug()) }}"><i class="fas fa-arrow-left"></i> Back to Options</a>
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <h4>Service: {{ $service->description }}</h4><br />
        <h4>Service Option: {{ $option->description }}</h4>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Requirement</legend>
        {!! Form::model(new App\AmdRequirement, ['route' => ['services.options.requirements.store', $service->slug(), $option->slug()], 'class' => 'form-group']) !!}
            @include('requirements/form', ['submit_text' => 'Create Requirement'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
