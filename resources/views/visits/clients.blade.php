@extends('app', ['page_title' => 'Patrol', 'open_menu' => 'task'])

@section('content')
<div class="row">
    <div class="col-8">
        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
            <thead>
                <tr class="text-center">
                    <th><strong>CLIENT</strong></th>
                    <th width="20%"><strong>NO. OF LOCATIONS</strong></th>
                    <th width="30%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)

                <tr>
                    <td>{{ $client->name }}<br />{{ $client->mobile_no }}<br />{{ $client->email }}</td>
                    <td align="center">{{ App\AmdErsLocation::where('client_id', $client->id)->where('active', true)->count() }}</td>
                    <td><a class="btn btn-primary btn-block btn-sm" href="{{ route('visits.locations', [$client->slug()]) }}">Select This Client</a></td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
