@extends('app', ['page_title' => 'States', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12">
        <legend>Edit State</legend>
        {!! Form::model($state, ['route' => ['states.update', $state->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
            @include('states/form', ['submit_text' => 'Update State'])
        {!! Form::close() !!}
    </div>
</div>
@endsection