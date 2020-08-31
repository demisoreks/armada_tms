@extends('app', ['page_title' => 'Detailing', 'open_menu' => 'task'])

<?php
if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
?>
@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('requests.submitted') }}"><i class="fas fa-list"></i> All Submitted Requests</a>
        <a class="btn btn-success" href="{{ route('requests.mark_assigned', $request->slug()) }}" onclick="return confirmMarkAsAssigned()"><i class="fas fa-check"></i> Mark as Assigned</a>
        <a class="btn btn-danger" href="{{ route('requests.cancel', $request->slug()) }}"><i class="fas fa-window-close"></i> Reject Request</a>
        <a class="btn btn-info" data-toggle="modal" data-target="#modal2"><i class="fas fa-forward"></i> Transfer Request</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <legend>Client Information</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="45%" class="font-weight-bold">Name</td>
                <td>{{ $request->client->name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Contact Person</td>
                <td>{{ $request->client->contact_person }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Mobile Number</td>
                <td>{{ $request->client->mobile_no }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Email Address</td>
                <td>{{ $request->client->email }}</td>
            </tr>
        </table>
        <legend>Request Details</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="45%" class="font-weight-bold">Service Type</td>
                <td>{{ $request->service_type }}</td>
            </tr>
            <tr>
                <td width="45%" class="font-weight-bold">Pickup/Service Date/Time</td>
                <td>{{ $request->service_date_time }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Pickup/Service Location</td>
                <td>{{ $request->service_location }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Name/Code</td>
                <td>{{ $request->principal_name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Mobile No.</td>
                <td>{{ $request->principal_mobile_no }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Email Address</td>
                <td>{{ $request->principal_email }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Additional Information</td>
                <td>{{ $request->additional_information }}</td>
            </tr>
        </table>

        <legend>Journey Stops</legend>
        @if (App\AmdRequestStop::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdRequestStop::where('request_id', $request->id)->get() as $request_stop)
            <tr>
                <td width="100%">{{ $request_stop->address }}</td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>
    <div class="col-lg-6">
        <legend>Service Selection</legend>
        @if (App\AmdRequestOption::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdRequestOption::where('request_id', $request->id)->get() as $request_option)
            <tr>
                <td width="60%">{{ App\AmdService::whereId(App\AmdOption::whereId($request_option->option_id)->first()->service_id)->first()->description }} | {{ App\AmdOption::whereId($request_option->option_id)->first()->description }}</td>
                <td>{{ date('M j', strtotime($request_option->start_date)) }} - {{ date('M j', strtotime($request_option->end_date)) }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Requirements</strong><br />
                    @foreach (App\AmdRequirement::where('option_id', $request_option->option_id)->get() as $requirement)
                        @if ($requirement->other_requirement_type == 0)
                            {{ App\AmdVehicleType::whereId($requirement->vehicle_type_id)->first()->description }}
                        @elseif ($requirement->other_requirement_type == 1)
                            Commander
                        @elseif ($requirement->other_requirement_type == 2)
                            Police
                        @endif
                        : {{ $requirement->quantity }}<br />
                    @endforeach
                </td>
            </tr>
            @endforeach
        </table>
        @endif

        <legend>Resource Assignment <span><a data-toggle="modal" data-target="#modal1" title="Add Resource"><i class="fas fa-plus"></i></a></span></legend>
        @if (App\AmdResource::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdResource::where('request_id', $request->id)->get() as $resource)
            <tr>
                <td width="50%">
                     @if ($resource->resource_type == 0)
                     Vehicle ({{ App\AmdVehicle::whereId($resource->resource_id)->first()->plate_number }})
                     @elseif ($resource->resource_type == 1)
                     Commander ({{ App\AmdUser::whereId($resource->resource_id)->first()->name }})
                     @elseif ($resource->resource_type == 2)
                     Police - {{ $resource->quantity }}
                     @endif
                </td>
                <td width="30%" class="text-right">
                     @if ($resource->resource_type == 0)
                     {{ number_format(App\AmdVehicleType::whereId(App\AmdVehicle::whereId($resource->resource_id)->first()->vehicle_type_id)->first()->average_daily_cost, 2) }}
                     @elseif ($resource->resource_type == 1)
                     {{ number_format(DB::table('amd_config')->whereId(1)->first()->commander_daily_cost, 2) }}
                     @elseif ($resource->resource_type == 2)
                     {{ number_format((DB::table('amd_config')->whereId(1)->first()->police_daily_cost * $resource->quantity), 2) }}
                     @endif
                </td>
                <td class="text-center"><a href="{{ route('requests.remove_resource', $resource->slug()) }}" title="Remove Resource"><i class="fas fa-trash"></i></a></td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>
</div>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Add Resource</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['route' => ['requests.add_resource', $request->slug()], 'class' => 'form-group']) !!}
                @include('requests/form4', ['submit_text' => 'Add Resource'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Transfer Request</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['route' => ['requests.transfer', $request->slug()], 'class' => 'form-group']) !!}
                @include('requests/form8', ['submit_text' => 'Transfer'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
