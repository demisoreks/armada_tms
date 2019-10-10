@extends('app', ['page_title' => 'Vehicle Types', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('vehicle_types.create') }}"><i class="fas fa-plus"></i> New Vehicle Type</a>
    </div>
</div>
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
                                    <th width="25%"><strong>DESCRIPTION</strong></th>
                                    <th><strong>FEATURES</strong></th>
                                    <th width="15%"><strong>PICK/DROP COST (=N=)</strong></th>
                                    <th width="15%"><strong>AVERAGE DAILY COST (=N=)</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicle_types as $vehicle_type)
                                    @if ($vehicle_type->active)
                                <tr>
                                    <td>{{ $vehicle_type->description }}</td>
                                    <td>{{ $vehicle_type->features }}</td>
                                    <td class="text-right">{{ number_format($vehicle_type->pick_and_drop_cost, 2) }}</td>
                                    <td class="text-right">{{ number_format($vehicle_type->average_daily_cost, 2) }}</td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('vehicle_types.edit', [$vehicle_type->slug()]) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                        <a title="Trash" href="{{ route('vehicle_types.disable', [$vehicle_type->slug()]) }}" onclick="return confirmDisable()"><i class="fas fa-trash"></i></a>
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
                                    <th width="25%"><strong>DESCRIPTION</strong></th>
                                    <th><strong>FEATURES</strong></th>
                                    <th width="15%"><strong>PICK/DROP COST (=N=)</strong></th>
                                    <th width="15%"><strong>AVERAGE DAILY COST (=N=)</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicle_types as $vehicle_type)
                                    @if (!$vehicle_type->active)
                                <tr>
                                    <td>{{ $vehicle_type->description }}</td>
                                    <td>{{ $vehicle_type->features }}</td>
                                    <td class="text-right">{{ number_format($vehicle_type->pick_and_drop_cost, 2) }}</td>
                                    <td class="text-right">{{ number_format($vehicle_type->average_daily_cost, 2) }}</td>
                                    <td class="text-center">
                                        <a title="Restore" href="{{ route('vehicle_types.enable', [$vehicle_type->slug()]) }}"><i class="fas fa-undo"></i></a>
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