@extends('app', ['page_title' => 'Vehicles', 'open_menu' => 'resource'])

<?php
if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
?>
@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('regions.vehicles.create', App\AmdRegion::whereId(App\AmdUser::where('employee_id', $halo_user->id)->first()->region_id)->first()->slug()) }}"><i class="fas fa-plus"></i> New Vehicle</a>
    </div>
</div>
<p class="text-info">
    NB: You can only manage vehicles in your region - {{ App\AmdRegion::whereId(App\AmdUser::where('employee_id', $halo_user->id)->first()->region_id)->first()->name }}
</p>
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <strong>Active</strong>
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
                                    <th width="10%"><strong>NEXT SERVICE</strong></th>
                                    <th width="10%"><strong>TRACKER IMEI</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicles as $vehicle)
                                    @if ($vehicle->active)
                                <tr>
                                    <td>{{ $vehicle->plate_number }}</td>
                                    <td>{{ $vehicle->driver }}</td>
                                    <td>{{ $vehicle->vehicleType->description }}</td>
                                    <td>{{ $vehicle->vendor->name }}</td>
                                    <td>{{ $vehicle->region->name }}</td>
                                    <td>{{ $vehicle->next_service_date }}</td>
                                    <td>{{ $vehicle->tracker_imei }}</td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('regions.vehicles.edit', [$region->slug(), $vehicle->slug()]) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                        <a title="Trash" href="{{ route('regions.vehicles.disable', [$region->slug(), $vehicle->slug()]) }}" onclick="return confirmDisable()"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading4" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                            <strong>Inactive</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable2" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="15%"><strong>PLATE NO.</strong></th>
                                    <th><strong>DRIVER</strong></th>
                                    <th width="15%"><strong>VEHICLE TYPE</strong></th>
                                    <th width="15%"><strong>VENDOR</strong></th>
                                    <th width="10%"><strong>REGION</strong></th>
                                    <th width="15%"><strong>NEXT SERVICE</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicles as $vehicle)
                                    @if (!$vehicle->active)
                                <tr>
                                    <td>{{ $vehicle->plate_number }}</td>
                                    <td>{{ $vehicle->driver }}</td>
                                    <td>{{ $vehicle->vehicleType->description }}</td>
                                    <td>{{ $vehicle->vendor->name }}</td>
                                    <td>{{ $vehicle->region->name }}</td>
                                    <td>{{ $vehicle->next_service_date }}</td>
                                    <td class="text-center">
                                        <a title="Restore" href="{{ route('regions.vehicles.enable', [$region->slug(), $vehicle->slug()]) }}"><i class="fas fa-undo"></i></a>
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
