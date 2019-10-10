@extends('app', ['page_title' => 'Requirements', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('services.options.requirements.create', [$service->slug(), $option->slug()]) }}"><i class="fas fa-plus"></i> New Requirement</a>
        <a class="btn btn-primary" href="{{ route('services.options.index', $service->slug()) }}"><i class="fas fa-arrow-left"></i> Back to Service Options</a>
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <h4>Service: {{ $service->description }}</h4><br />
        <h4>Service Option: {{ $option->description }}</h4>
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
                                    <th><strong>REQUIREMENT</strong></th>
                                    <th width="15%"><strong>QUANTITY</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requirements as $requirement)
                                    
                                <tr>
                                    <td>
                                        @if ($requirement->other_requirement_type == 0)
                                            {{ App\AmdVehicleType::whereId($requirement->vehicle_type_id)->first()->description }}
                                        @elseif ($requirement->other_requirement_type == 1)
                                            Commander
                                        @elseif ($requirement->other_requirement_type == 2)
                                            Police
                                        @endif
                                    </td>
                                    <td class="text-right">{{ number_format($requirement->quantity) }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('services.options.requirements.destroy', [$service->slug(), $option->slug(), $requirement->slug()]) }}" method="POST">
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