@extends('app', ['page_title' => 'Request Details', 'open_menu' => 'analytics'])

@section('content')
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
                <td width="45%" class="font-weight-bold">Pickup/Service Date/Time</td>
                <td>{{ $request->service_date_time }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Pickup/Service Location</td>
                <td>{{ $request->service_location }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Principal's Name</td>
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

        @if ($request->service_type == "SM")
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
        @endif

        <legend>Feedback</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td width="25%" class="font-weight-bold">Rating</td>
                <td>{{ $request->rating }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Comment</td>
                <td>{{ $request->feedback }}</td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6">
        @if ($request->service_type == "SM")
        <legend>Service Selection</legend>
        @if (App\AmdRequestOption::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdRequestOption::where('request_id', $request->id)->get() as $request_option)
            <tr>
                <td width="60%">{{ App\AmdService::whereId(App\AmdOption::whereId($request_option->option_id)->first()->service_id)->first()->description }} | {{ App\AmdOption::whereId($request_option->option_id)->first()->description }}</td>
                <td>{{ date('M j', strtotime($request_option->start_date)) }} - {{ date('M j', strtotime($request_option->end_date)) }}</td>
            </tr>
            @endforeach
        </table>
        @endif
        @endif

        <legend>Resources</legend>
        @if (App\AmdResource::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdResource::where('request_id', $request->id)->orderBy('resource_type')->get() as $resource)
            <tr>
                <td>
                     @if ($resource->resource_type == 0)
                     Vehicle ({{ App\AmdVehicle::whereId($resource->resource_id)->first()->plate_number }})
                     @elseif ($resource->resource_type == 1)
                     Commander ({{ App\AmdUser::whereId($resource->resource_id)->first()->name }})
                     @elseif ($resource->resource_type == 2)
                     Police - {{ $resource->quantity }}
                     @endif
                </td>
            </tr>
            @endforeach
        </table>
        @endif

        @if ($request->service_type == "ER")

        <legend>Incident(s)</legend>
        @if (App\AmdIncident::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdIncident::where('request_id', $request->id)->get() as $incident)
            <tr>
                <td>
                    {{ $incident->incidentType->description }} | {{ $incident->incident_date_time }}<br />
                    <strong>Description:</strong> {{ $incident->description }}<br />
                    <strong>Action Taken:</strong> {{ $incident->action_taken }}<br />
                    <strong>Follow-up Action:</strong> {{ $incident->follow_up_action }}<br />
                </td>
            </tr>
            @endforeach
        </table>
        @endif

        <legend>Uploaded Files</legend>
        @if (App\AmdErsFile::where('request_id', $request->id)->count() > 0)
        <table class="table table-hover table-bordered table-striped">
            @foreach (App\AmdErsFile::where('request_id', $request->id)->get() as $file)
            <tr>
                <td>{{ $file->description }}</td>
                <td width="100" align="center"><a title="View/Download File" class="btn btn-info btn-sm" href="{{ config('app.url') }}{{ Storage::url('public/ers/evidences/'.$file->filename.'.'.$file->extension) }}" target="_blank">View/Download</a></td>
            </tr>
            @endforeach
        </table>
        @endif

        <legend>Checklist</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <td>
                    Entry Time<br />
                    <span class="text-info">{{ App\AmdErsVisit::where('request_id', $request->id)->first()->entry_time }}</span><br />
                </td>
            </tr>
            <tr>
                <td>
                    Exit Time<br />
                    <span class="text-info">{{ App\AmdErsVisit::where('request_id', $request->id)->first()->exit_time }}</span><br />
                </td>
            </tr>
            @foreach (App\AmdErsVisitDetail::where('ers_visit_id', App\AmdErsVisit::where('request_id', $request->id)->first()->id)->get() as $detail)
            <tr>
                <td>
                    {{ $detail->description }}<br />
                    <span class="text-info">{{ $detail->option }}</span><br />
                </td>
            </tr>
            @endforeach
            <tr>
                <td>
                    Detailer's Comment<br />
                    <span class="text-info">{{ $request->detailer_review }}</span><br />
                </td>
            </tr>
        </table>

        @endif

        <legend>Request Flow</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <th width="35%">Date/Time</th>
                <th width="30%">Action</th>
                <th>Action By</th>
            </tr>
            @foreach (App\AmdRequestStatus::where('request_id', $request->id)->orderBy('created_at')->get() as $request_status)
            <tr>
                <td>{{ $request_status->created_at }}</td>
                <td>{{ App\AmdStatus::whereId($request_status->status_id)->first()->description }}</td>
                <td>{{ App\AccEmployee::whereId($request_status->updated_by)->first()->username }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="col-12">
        <legend>Situation Reports</legend>
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <th width="10%">Date/Time</th>
                <th width="15%">Situation</th>
                <th width="18%">Location</th>
                <th width="17%">Close Landmark</th>
                <th width="20%">Remarks</th>
                <th width="20%">Submitted By</th>
            </tr>
            @foreach (App\AmdSituationReport::where('request_id', $request->id)->orderBy('created_at')->get() as $situation_report)
            <tr>
                <td>{{ $situation_report->created_at }}</td>
                <td>{{ App\AmdSituation::whereId($situation_report->situation_id)->first()->description }}</td>
                <td>{{ $situation_report->location }}</td>
                <td>{{ $situation_report->close_landmark }}</td>
                <td>{{ $situation_report->remarks }}</td>
                <td>{{ App\AccEmployee::whereId(App\AmdUser::whereId($situation_report->user_id)->first()->employee_id)->first()->username }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
