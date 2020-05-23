@extends('app', ['page_title' => 'ERS Clients', 'open_menu' => 'ers'])

@section('content')
<legend>Pending Clients</legend>
<div class="row">
    <div class="col-12">
        <table id="myTable3" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
            <thead>
                <tr class="text-center">
                    <th width="10%"><strong>ENROLMENT DATE/TIME</strong></th>
                    <th><strong>NAME</strong></th>
                    <th width="26%"><strong>HOME ADDRESS</strong></th>
                    <th width="10%"><strong>PRIMARY PHONE</strong></th>
                    <th width="10%"><strong>ALTERNATE PHONE</strong></th>
                    <th width="15%"><strong>EMAIL ADDRESS</strong></th>
                    <th width="10%" data-priority="1">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->created_at }}</td>
                    <td>{{ $client->title }} {{ $client->first_name }} {{ $client->surname }}</td>
                    <td>{!! nl2br($client->home_address) !!}</td>
                    <td>{{ $client->primary_phone }}</td>
                    <td>{{ $client->alternate_phone }}</td>
                    <td>{{ $client->email }}</td>
                    <td><a class="btn btn-primary btn-block btn-sm" href="{{ route('ers_clients.view', [$client->slug()]) }}">View Details</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
