@extends('app', ['page_title' => 'Services', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('services.index') }}"><i class="fas fa-list"></i> Existing Services</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Service</legend>
        {!! Form::model(new App\AmdService, ['route' => ['services.store'], 'class' => 'form-group']) !!}
            @include('services/form', ['submit_text' => 'Create Service'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
