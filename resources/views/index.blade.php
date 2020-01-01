@extends('app', ['page_title' => config('app.name')])

<?php
use GuzzleHttp\Client;

if (!isset($_SESSION)) session_start();
$halo_user = $_SESSION['halo_user'];
        
$client = new Client();
$res = $client->request('GET', DB::table('acc_config')->whereId(1)->first()->master_url.'/api/getRoles', [
    'query' => [
        'username' => $halo_user->username,
        'link_id' => DB::table('amd_config')->whereId(1)->first()->link_id
    ]
]);
$permissions = json_decode($res->getBody());
?>
@section('content')
@include('commons.message')

<div class="row">
    @if (count(array_intersect($permissions, ['Commander','Detailer'])) != 0)
    <div class="col-12">
        <h4 class="page-header text-primary" style="border-bottom: 1px solid #999; padding-bottom: 20px; margin-bottom: 20px;">Task Management</h4>
    </div>
    @if (count(array_intersect($permissions, ['Commander'])) != 0)
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('requests.assigned') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-tasks"></i></h1>
                    <h5 class="text-primary">My Tasks</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
    @if (count(array_intersect($permissions, ['Detailer'])) != 0)
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('requests.submitted') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-share"></i></h1>
                    <h5 class="text-primary">Detailing</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
    @endif
    @if (count(array_intersect($permissions, ['Admin','Detailer'])) != 0)
    <div class="col-12">
        <h4 class="page-header text-primary" style="border-bottom: 1px solid #999; padding-bottom: 20px; margin-bottom: 20px;">Client Management</h4>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('clients.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-users"></i></h1>
                    <h5 class="text-primary">Clients</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('requests.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-stream"></i></h1>
                    <h5 class="text-primary">Service Requests</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
    @if (count(array_intersect($permissions, ['Detailer'])) != 0)
    <div class="col-12">
        <h4 class="page-header text-primary" style="border-bottom: 1px solid #999; padding-bottom: 20px; margin-bottom: 20px;">Resource Management</h4>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('regions.vehicles.index', App\AmdRegion::whereId(App\AmdUser::where('employee_id', $halo_user->id)->first()->region_id)->first()->slug()) }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-truck-pickup"></i></h1>
                    <h5 class="text-primary">Vehicles</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('downtimes.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-arrow-circle-down"></i></h1>
                    <h5 class="text-primary">Resource Downtime</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
    @if (count(array_intersect($permissions, ['Admin'])) != 0)
    <div class="col-12">
        <h4 class="page-header text-primary" style="border-bottom: 1px solid #999; padding-bottom: 20px; margin-bottom: 20px;">Administration</h4>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('services.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-handshake"></i></h1>
                    <h5 class="text-primary">Services</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('vehicle_types.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-car"></i></h1>
                    <h5 class="text-primary">Vehicle Types</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('vendors.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-shopping-cart"></i></h1>
                    <h5 class="text-primary">Vendors</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('users.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-user"></i></h1>
                    <h5 class="text-primary">Users</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('states.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-flag"></i></h1>
                    <h5 class="text-primary">States</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('regions.index') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-map"></i></h1>
                    <h5 class="text-primary">Regions</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3" style="margin-bottom: 20px;">
        <a href="{{ route('config') }}">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-info"><i class="fas fa-cogs"></i></h1>
                    <h5 class="text-primary">Configuration</h5>
                </div>
            </div>
        </a>
    </div>
    @endif
</div>

<script type="text/javascript">
    $(document).ready(function () {
	$('.carousel').carousel({
		interval: 3000,
		pause: "hover"
	});
    });
</script>
@endsection