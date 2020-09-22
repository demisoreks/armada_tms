@extends('app', ['page_title' => 'Clients', 'open_menu' => 'client'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('clients.create') }}"><i class="fas fa-plus"></i> New Client</a>
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
                                    <th><strong>NAME</strong></th>
                                    <th width="15%"><strong>CONTACT PERSON</strong></th>
                                    <th width="8%"><strong>MOBILE NO.</strong></th>
                                    <th width="20%"><strong>EMAIL ADDRESS</strong></th>
                                    <th width="15%"><strong>ADDRESS</strong></th>
                                    <th width="7%"><strong>ERS CODE NAME</strong></th>
                                    <th><strong>ERS REPORT LINKS</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    @if ($client->active)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->contact_person }}</td>
                                    <td>{{ $client->mobile_no }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>{{ $client->ers_code_name }}</td>
                                    <td>
                                        <strong>Responses:</strong> {{ config('app.url')."/reports/clients/".$client->slug()."/responses" }}<br />
                                        <strong>Patrol Visits:</strong> {{ config('app.url')."/reports/clients/".$client->slug()."/patrols" }}
                                    </td>
                                    <td><a class="btn btn-primary btn-block btn-sm" href="{{ route('requests.initiate', $client->slug()) }}">Make Request</a></td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('clients.edit', [$client->slug()]) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                        <a title="Trash" href="{{ route('clients.disable', [$client->slug()]) }}" onclick="return confirmDisable()"><i class="fas fa-trash"></i></a>
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
                                    <th><strong>NAME</strong></th>
                                    <th width="15%"><strong>CONTACT PERSON</strong></th>
                                    <th width="15%"><strong>MOBILE NO.</strong></th>
                                    <th width="20%"><strong>EMAIL ADDRESS</strong></th>
                                    <th width="20%"><strong>ADDRESS</strong></th>
                                    <th width="10%" data-priority="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    @if (!$client->active)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->contact_person }}</td>
                                    <td>{{ $client->mobile_no }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td class="text-center">
                                        <a title="Restore" href="{{ route('clients.enable', [$client->slug()]) }}"><i class="fas fa-undo"></i></a>
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
