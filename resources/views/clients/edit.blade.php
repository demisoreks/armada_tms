@extends('app', ['page_title' => 'Clients', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('clients.index') }}"><i class="fas fa-list"></i> Existing Clients</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Client</legend>
        {!! Form::model($client, ['route' => ['clients.update', $client->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('clients/form', ['submit_text' => 'Update Client'])
        {!! Form::close() !!}
    </div>
</div>
@endsection