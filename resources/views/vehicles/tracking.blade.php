@extends('app', ['page_title' => 'Vehicle Tracking', 'open_menu' => 'resource'])

@section('content')
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <strong>Active Vehicles</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="15%"><strong>PLATE NO.</strong></th>
                                    <th><strong>DRIVER</strong></th>
                                    <th width="15%"><strong>VEHICLE TYPE</strong></th>
                                    <th width="15%"><strong>VENDOR</strong></th>
                                    <th width="10%"><strong>REGION</strong></th>
                                    <th width="15%"><strong>TRACEKR IMEI</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->plate_number }}</td>
                                    <td>{{ $vehicle->driver }}</td>
                                    <td>{{ $vehicle->vehicleType->description }}</td>
                                    <td>{{ $vehicle->vendor->name }}</td>
                                    <td>{{ $vehicle->region->name }}</td>
                                    <td>{{ $vehicle->tracker_imei }}</td>
                                    <td class="text-center">
                                        @if ($vehicle->tracker_imei)
                                        <a class="btn btn-sm btn-block btn-primary" title="Edit" href="{{ route('vehicles.track', [$vehicle->slug()]) }}">Track</a>
                                        @endif
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
