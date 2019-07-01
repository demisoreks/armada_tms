@extends('app', ['page_title' => 'Resource Downtime', 'open_menu' => 'resource'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('downtimes.create') }}"><i class="fas fa-plus"></i> New Downtime</a>
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
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="20%"><strong>START DATE/TIME</strong></th>
                                    <th width="20%"><strong>END DATE/TIME</strong></th>
                                    <th><strong>RESOURCE</strong></th>
                                    <th width="20%"><strong>RESOURCE TYPE</strong></th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($downtimes as $downtime)
                                    
                                <tr>
                                    <td>{{ $downtime->start_date_time }}</td>
                                    <td>{{ $downtime->end_date_time }}</td>
                                    @if ($downtime->resource_type == 0)
                                    <td>{{ App\AmdVehicle::whereId($downtime->resource_id)->first()->plate_number }} ({{ App\AmdVehicleType::whereId(App\AmdVehicle::whereId($downtime->resource_id)->first()->vehicle_type_id)->first()->description }})</td>
                                    <td>Vehicle</td>
                                    @elseif ($downtime->resource_type == 1)
                                    <td>{{ App\AmdUser::whereId($downtime->resource_id)->first()->name }}</td>
                                    <td>Commander</td>
                                    @else
                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td class="text-center">
                                        <form action="{{ route('downtimes.destroy', $downtime->slug()) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-link" style="padding: 0; margin: 0" title="Trash" onclick="return confirmDelete()"><i class="fas fa-trash"></i></button>
                                        </form>
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