@extends('app', ['page_title' => 'Resource Downtime', 'open_menu' => 'resource'])

<?php
if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
?>
@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('downtimes.index') }}"><i class="fas fa-list"></i> Existing Downtime</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Downtime</legend>
        {!! Form::model(new App\AmdDowntime, ['route' => 'downtimes.store', 'class' => 'form-group']) !!}
            @include('downtimes/form', ['submit_text' => 'Create Downtime'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
