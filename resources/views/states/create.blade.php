@extends('app', ['page_title' => 'Regions'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('regions.index') }}"><i class="fas fa-list"></i> Existing Regions</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Region</legend>
        {!! Form::model(new App\AmdRegion, ['route' => ['regions.store'], 'class' => 'form-group']) !!}
            @include('regions/form', ['submit_text' => 'Create Region'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
