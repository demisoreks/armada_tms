@extends('app', ['page_title' => 'Task Board', 'more' => 2])

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
    <div class="col-12">
        <div id="board" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $count = 1;
                ?>
                @foreach (App\AmdRegion::where('active', true)->get() as $region)
                <div class="carousel-item @if ($count == 1) active @endif">
                    <h3>{{ $region->name }} Region</h3>
                    <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th width="15%"><strong>PICKUP/SERVICE DATE/TIME</strong></th>
                                <th><strong>CLIENT INFORMATION</strong></th>
                                <th width="20%"><strong>PRINCIPAL'S DETAILS</strong></th>
                                <th width="20%"><strong>COMMANDER(S)</strong></th>
                                <th width="15%"><strong>STATUS</strong></th>
                                <th width="10%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\AmdRequest::where('region_id', $region->id)->whereRaw('status_id in (2,4,5)')->get() as $request)
                                
                            <tr>
                                <td>{{ $request->service_date_time }}</td>
                                <td>{{ $request->client->name }}<br />{{ $request->client->mobile_no }}<br />{{ $request->client->email }}</td>
                                <td>{{ $request->principal_name }}<br />{{ $request->principal_mobile_no }}<br />{{ $request->principal_email }}</td>
                                <td>
                                    @foreach (App\AmdResource::where('request_id', $request->id)->where('resource_type', 1)->get() as $resource)
                                    {{ App\AmdUser::whereId($resource->resource_id)->first()->name }}<br />{{ App\AmdUser::whereId($resource->resource_id)->first()->mobile_no }}<br />
                                    @endforeach
                                </td>
                                <td>{{ $request->status->description }}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-block btn-sm" href="{{ route('requests.jmp', [$request->slug()]) }}" target="_blank">JMP</a>
                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <?php
                $count ++;
                ?>
                @endforeach
            </div>
            <!--
            <a class="carousel-control-prev" href="#board" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#board" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            -->
        </div>
    </div>
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