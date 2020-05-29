@extends('app', ['page_title' => 'ERS Clients', 'open_menu' => 'ers'])

<?php
use GuzzleHttp\Client;

if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];

$client = new Client();
$res = $client->request('GET', DB::table('acc_config')->whereId(1)->first()->master_url.'/api/getRoles', [
    'query' => [
        'username' => $halo_user->username,
        'link_id' => DB::table('amd_config')->whereId(1)->first()->link_id
    ]
]);
$permissions = json_decode($res->getBody());
?>

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-warning" href="{{ route('ers_clients.pending') }}">Pending Clients</a>
        <a class="btn btn-info" href="{{ route('ers_clients.active') }}">Active Clients</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <table class="display-1 table table-condensed table-hover table-striped" width="100%">
            <tr>
                <th><strong>CLIENT INFORMATION</strong></th>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col"><small>Name</small><br /><strong>{{ $ers_client->title }} {{ $ers_client->first_name }} {{ $ers_client->surname }}</strong></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col"><small>Date of Birth</small><br /><strong>{{ Carbon\Carbon::parse($ers_client->date_of_birth)->format('F j, Y') }}</strong></div>
                        <div class="col"><small>Gender</small><br /><strong>{{ $ers_client->gender }}</strong></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col"><small>Home Address</small><br /><strong>{!! nl2br($ers_client->home_address) !!}</strong></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col"><small>Primary Phone</small><br /><strong>{{ $ers_client->primary_phone }}</strong></div>
                        <div class="col"><small>Alternate Phone</small><br /><strong>{{ $ers_client->alternate_phone }}</strong></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col"><small>Email Address</small><br /><strong>{{ $ers_client->email }}</strong></div>
                        <div class="col"><small>Occupation</small><br /><strong>{{ $ers_client->occupation }}</strong></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col"><small>Status</small><br /><strong class="@if ($ers_client->status == 'Pending') text-warning @elseif ($ers_client->status == 'Active') text-info @elseif ($ers_client->status == 'Rejected') text-danger @endif">{{ $ers_client->status }}</strong></div>
                        <div class="col"><small>Enrolment Date</small><br /><strong>{{ Carbon\Carbon::parse($ers_client->created_at)->format('F j, Y') }}</strong></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="display-1 table table-condensed table-hover table-striped" width="100%">
            <tr>
                <th><strong>DOCUMENTATION</strong></th>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        @if ($identity_link) <div class="col"><small>Identity Document</small><br /><strong><a href="{{ $identity_link }}" target="_blank">Click to view</a></strong></div> @endif
                        @if ($utility_link) <div class="col"><small>Utility Document</small><br /><strong><a href="{{ $utility_link }}" target="_blank">Click to view</a></strong></div> @endif
                    </div>
                </td>
            </tr>
        </table>

        @if ($ers_client->status == 'Pending')
        @if (count(array_intersect($permissions, ['ControlRoom'])) != 0)

        {!! Form::model(null, ['route' => ['ers_clients.treat', $ers_client->slug()], 'class' => 'form-group']) !!}
        <div class="form-group row">
            {!! Form::label('status', 'Action *', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('status', ['Active' => 'Activate', 'Rejected' => 'Reject'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('comment', 'Comment *', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::textarea('comment', $value = null, ['class' => 'form-control', 'placeholder' => 'Comment', 'required' => true, 'maxlength' => 200, 'rows' => 4]) !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-8 offset-md-4">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}

        @endif
        @else

        <table class="display-1 table table-condensed table-hover table-striped" width="100%">
            <tr>
                <th><strong>ACTIVATION</strong></th>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col"><small>Treated By</small><br /><strong>{{ App\AccEmployee::whereId($ers_client->treated_by)->first()->username }}</strong></div>
                        <div class="col"><small>Date Treated</small><br /><strong>{{ Carbon\Carbon::parse($ers_client->treated_at)->format('F j, Y') }}</strong></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col"><small>Home Address</small><br /><strong>{!! nl2br($ers_client->comment) !!}</strong></div>
                    </div>
                </td>
            </tr>
        </table>
        <h2 class="text-center">{{ $ers_client->access_code }}</h2>

        @endif
    </div>
</div>
@endsection
