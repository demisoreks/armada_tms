@extends('app', ['page_title' => 'Incident Review', 'open_menu' => 'task'])

@section('content')
<p class="text-info">
    <span class="font-weight-bold">NB:</span><br />You can only review incidents within your assigned region.
</p>
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <strong>Pending Incidents</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%"><strong>DATE/TIME REPORTED</strong></th>
                                    <th><strong>CLIENT NAME AND LOCATION</strong></th>
                                    <th width="10%"><strong>INCIDENT TYPE</strong></th>
                                    <th width="20%"><strong>REPORTED BY</strong></th>
                                    <th width="15%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)

                                <tr>
                                    <td>{{ App\AmdRequestStatus::where('request_id', $request->id)->where('status_id', App\AmdStatus::where('description', 'Completed')->first()->id)->first()->created_at }}</td>
                                    <td>{{ $request->client->name }} - {{ $request->principal_name }}</td>
                                    <td>
                                        @foreach (App\AmdIncident::where('request_id', $request->id)->get() as $incident)
                                        {{ $incident->incidentType->description }}<br />
                                        @endforeach
                                    </td>
                                    <td>@if ($request->user_id) {{ App\AmdUser::find($request->user_id)->first()->name }} @endif</td>
                                    <td><a class="btn btn-primary btn-block btn-sm" href="{{ route('incidents.approve', [$request->slug()]) }}"><i class="fas fa-eye"></i> Review</a></td>
                                </tr>

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
