@extends('app', ['page_title' => 'Regions', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('regions.index') }}"><i class="fas fa-list"></i> Existing Regions</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Region</legend>
        {!! Form::model($region, ['route' => ['regions.update', $region->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('regions/form', ['submit_text' => 'Update Region'])
        {!! Form::close() !!}
    </div>
</div>
@endsection