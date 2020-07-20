@extends('app', ['page_title' => 'Vehicle Tracking', 'open_menu' => 'resource'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('vehicles.tracking') }}"><i class="fas fa-arrow-left"></i> Back to Vehicle List</a>
        <a class="btn btn btn-red" href="https://maps.google.com/?q={{ $data['latitude'] }},{{ $data['longitude'] }}" target="_blank"><i class="fas fa-map"></i> View on Map</a>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>VEHICLE DETAILS</strong>
            </div>
            <div class="card-body bg-white">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <td><strong>Plate Number</strong></td>
                        <td>{{ $vehicle->plate_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Driver</strong></td>
                        <td>{{ $vehicle->driver }}</td>
                    </tr>
                    <tr>
                        <td><strong>Region</strong></td>
                        <td>{{ $vehicle->region->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Vehicle Type</strong></td>
                        <td>{{ $vehicle->vehicleType->description }}</td>
                    </tr>
                    <tr>
                        <td><strong>Vendor</strong></td>
                        <td>{{ $vehicle->vendor->name }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">

        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>LATEST TRACKING INFO</strong>
            </div>
            <div class="card-body bg-white">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <td><strong>Tracker IMEI</strong></td>
                        <td>{{ $vehicle->tracker_imei }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date/Time</strong></td>
                        <td>{{ Carbon\Carbon::parse($data['date_time'])->format('F j, Y g:ia') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Latitude, Longitude</strong></td>
                        <td>{{ $data['latitude'] }}, {{ $data['longitude'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Speed</strong></td>
                        <td>{{ $data['speed'] }}km/h</td>
                    </tr>
                    <tr>
                        <td><strong>Address</strong></td>
                        <td>{{ $data['address'] }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
