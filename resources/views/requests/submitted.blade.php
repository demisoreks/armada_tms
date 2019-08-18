@extends('app', ['page_title' => 'Detailing'])

<?php
if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
?>
@section('content')
<p class="text-info">
    <span class="font-weight-bold">NB:</span><br />This page shows only requests that fall under your region.
</p>
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <strong>Submitted Requests</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%"><strong>DATE/TIME SUBMITTED</strong></th>
                                    <th><strong>CLIENT INFORMATION</strong></th>
                                    <th width="15%"><strong>SUBMITTED BY</strong></th>
                                    <th width="20%"><strong>PICKUP/SERVICE LOCATION</strong></th>
                                    <th width="20%"><strong>STOPS</strong></th>
                                    <th width="15%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    @if ($request->region_id == App\AmdUser::where('employee_id', $halo_user->id)->first()->region_id)
                                <tr>
                                    <td>{{ App\AmdRequestStatus::where('request_id', $request->id)->where('status_id', 2)->first()->created_at }}</td>
                                    <td>{{ $request->client->name }}<br />{{ $request->client->mobile_no }}<br />{{ $request->client->email }}</td>
                                    <td>@if (App\AmdRequestStatus::where('request_id', $request->id)->where('status_id', 2)->first()->updated_by == 0) CLIENT @else {{ App\AccEmployee::whereId(App\AmdRequestStatus::where('request_id', $request->id)->where('status_id', 2)->first()->updated_by)->first()->username }} @endif</td>
                                    <td>{{ $request->service_location }}</td>
                                    <td>
                                        @foreach (App\AmdRequestStop::where('request_id', $request->id)->get() as $stop)
                                            - {{ $stop->address }}<br />
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-block btn-sm" href="{{ route('requests.treat', [$request->slug()]) }}">Treat Request</a>
                                    </td>
                                </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection