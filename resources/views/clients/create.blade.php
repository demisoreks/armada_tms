@extends('app', ['page_title' => 'Clients', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('clients.index') }}"><i class="fas fa-list"></i> Existing Clients</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Client</legend>
        {!! Form::model(new App\AmdClient, ['route' => ['clients.store'], 'class' => 'form-group']) !!}
            @include('clients/form', ['submit_text' => 'Create Client'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
