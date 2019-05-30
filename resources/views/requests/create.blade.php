@extends('app', ['page_title' => 'Service Requests', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('requests.index') }}"><i class="fas fa-list"></i> Initiated Requests</a>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <legend>New Request</legend>
        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
            <thead>
                <tr class="text-center">
                    <th><strong>CLIENT</strong></th>
                    <th width="30%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\AmdClient::where('active', true)->get() as $client)

                <tr>
                    <td>{{ $client->name }}<br />{{ $client->mobile_no }}<br />{{ $client->email }}</td>
                    <td><a class="btn btn-primary btn-block btn-sm" href="{{ route('requests.initiate', [$client->slug()]) }}">Select This Client</a></td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
