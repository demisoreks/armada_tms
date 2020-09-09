@extends('app', ['page_title' => 'Patrol', 'open_menu' => 'task'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('visits.clients') }}"><i class="fas fa-arrow-left"></i> Back to Clients</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <strong>Active ERS Locations</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="15%"><strong>LOCATION NAME</strong></th>
                                    <th width="20%"><strong>CLIENT</strong></th>
                                    <th><strong>ADDRESS</strong></th>
                                    <th width="20%"><strong>COORDINATES</strong></th>
                                    <th width="20%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ers_locations as $ers_location)
                                <tr>
                                    <td>{{ $ers_location->name }}</td>
                                    <td>{{ $ers_location->client->name }}</td>
                                    <td>{{ $ers_location->address }}</td>
                                    <td>{{ $ers_location->latitude }},{{ $ers_location->longitude }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-block btn-sm" href="{{ route('visits.create', [$ers_location->slug()]) }}">Select This Location</a>
                                    </td>
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
