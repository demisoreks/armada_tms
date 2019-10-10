@extends('app', ['page_title' => 'States', 'open_menu' => 'admin'])

@section('content')
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
                                    <th><strong>NAME</strong></th>
                                    <th width="40%"><strong>REGION</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($states as $state)
                                    
                                <tr>
                                    <td>{{ $state->name }}</td>
                                    <td>{{ $state->region->name }}</td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('states.edit', [$state->slug()]) }}"><i class="fas fa-edit"></i></a>
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