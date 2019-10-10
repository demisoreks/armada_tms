@extends('app', ['page_title' => 'Service Options', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('services.options.create', $service->slug()) }}"><i class="fas fa-plus"></i> New Option</a>
        <a class="btn btn-primary" href="{{ route('services.index') }}"><i class="fas fa-arrow-left"></i> Back to Services</a>
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <h4>Service: {{ $service->description }}</h4>
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
                                    <th width="20%"><strong>DESCRIPTION</strong></th>
                                    <th><strong>OFFERINGS</strong></th>
                                    <th width="15%"><strong>PRICE (=N=)</strong></th>
                                    <th width="15%" data-priority="1">&nbsp;</th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $option)
                                    @if ($option->active)
                                <tr>
                                    <td>{{ $option->description }}</td>
                                    <td>{{ $option->offerings }}</td>
                                    <td class="text-right">{{ number_format($option->price, 2) }}</td>
                                    <td><a class="btn btn-primary btn-block btn-sm" href="{{ route('services.options.requirements.index', [$service->slug(), $option->slug()]) }}">Manage Requirements</a></td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('services.options.edit', [$service->slug(), $option->slug()]) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                        <a title="Trash" href="{{ route('services.options.disable', [$service->slug(), $option->slug()]) }}" onclick="return confirmDisable()"><i class="fas fa-trash"></i></a>
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
                                    <th width="20%"><strong>DESCRIPTION</strong></th>
                                    <th><strong>OFFERINGS</strong></th>
                                    <th width="15%"><strong>PRICE (=N=)</strong></th>
                                    <th width="15%" data-priority="1">&nbsp;</th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $option)
                                    @if (!$option->active)
                                <tr>
                                    <td>{{ $option->description }}</td>
                                    <td>{{ $option->offerings }}</td>
                                    <td class="text-right">{{ number_format($option->price, 2) }}</td>
                                    <td><a class="btn btn-primary btn-block btn-sm" href="{{ route('services.options.requirements.index', [$service->slug(), $option->slug()]) }}">Manage Requirements</a></td>
                                    <td class="text-center">
                                        <a title="Restore" href="{{ route('services.options.enable', [$service->slug(), $option->slug()]) }}"><i class="fas fa-undo"></i></a>
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