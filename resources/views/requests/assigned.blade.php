@extends('app', ['page_title' => 'My Tasks'])

<?php
if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
?>
@section('content')
<div class="row">
    <div class="col-12">
        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
            <thead>
                <tr class="text-center">
                    <th width="15%"><strong>PICKUP/SERVICE DATE/TIME</strong></th>
                    <th><strong>CLIENT INFORMATION</strong></th>
                    <th width="20%"><strong>PICKUP/SERVICE LOCATION</strong></th>
                    <th width="20%"><strong>STOPS</strong></th>
                    <th width="10%"><strong>STATUS</strong></th>
                    <th width="10%">&nbsp;</th>
                    <th width="10%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)

                <tr>
                    <td>{{ $request->service_date_time }}</td>
                    <td>{{ $request->client->name }}<br />{{ $request->client->mobile_no }}<br />{{ $request->client->email }}</td>
                    <td>{{ $request->service_location }}</td>
                    <td>
                        @foreach (App\AmdRequestStop::where('request_id', $request->id)->get() as $stop)
                            - {{ $stop->address }}<br />
                        @endforeach
                    </td>
                    <td>{{ $request->status->description }}</td>
                    <td>
                        <a class="btn btn-warning btn-block btn-sm" href="{{ route('requests.jmp', [$request->slug()]) }}" target="_blank">JMP</a>
                    </td>
                    <td>
                        @if ($request->status->description == "Assigned")
                        <a class="btn btn-info btn-block btn-sm" href="{{ route('requests.acknowledge', [$request->slug()]) }}">Acknowledge</a>
                        @else
                        <a class="btn btn-primary btn-block btn-sm" href="{{ route('requests.manage', [$request->slug()]) }}">Manage</a>
                        @endif
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection