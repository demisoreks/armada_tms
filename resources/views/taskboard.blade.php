<?php
use GuzzleHttp\Client;
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Taskboard | {{ config('app.name') }}</title>
        
        <style type="text/css">
        #map {
          height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
          height: 100%;
          margin: 0;
          padding: 0;
        }
        #description {
          font-family: Roboto;
          font-size: 15px;
          font-weight: 300;
        }

        #infowindow-content .title {
          font-weight: bold;
        }

        #infowindow-content {
          display: none;
        }

        #map #infowindow-content {
          display: inline;
        }

        .pac-card {
          margin: 10px 10px 0 0;
          border-radius: 2px 0 0 2px;
          box-sizing: border-box;
          -moz-box-sizing: border-box;
          outline: none;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
          background-color: #fff;
          font-family: Roboto;
        }

        #pac-container {
          padding-bottom: 12px;
          margin-right: 12px;
        }

        .pac-controls {
          display: inline-block;
          padding: 5px 11px;
        }

        .pac-controls label {
          font-family: Roboto;
          font-size: 13px;
          font-weight: 300;
        }

        #pac-input {
          background-color: #fff;
          font-family: Roboto;
          font-size: 15px;
          font-weight: 300;
          margin-left: 12px;
          padding: 0 11px 0 13px;
          text-overflow: ellipsis;
          width: 400px;
        }

        #pac-input:focus {
          border-color: #4d90fe;
        }

        #title {
          color: #fff;
          background-color: #4d90fe;
          font-size: 25px;
          font-weight: 500;
          padding: 6px 12px;
        }
        #target {
          width: 345px;
        }
        
        .pac-container {
            background-color: #FFF;
            z-index: 100000;
            position: absolute;
            display: inline-block;
            float: left;
        }
        .modal{
            z-index: 2000;
        }
        .modal-backdrop{
            z-index: 1000;
        }​
        </style>
        
        {!! Html::style('css/app.css') !!}
        {!! Html::style('css/mdb.min.css') !!}
        {!! Html::style('css/datatables.min.css') !!}
        {!! Html::style('fontawesome/css/all.css') !!}
        
        {!! Html::script('js/jquery-3.3.1.min.js') !!}
        {!! Html::script('js/popper.min.js') !!}
        {!! Html::script('js/app.js') !!}
        {!! Html::script('js/mdb.min.js') !!}
        {!! Html::script('js/datatables.min.js') !!}
        
        <script type="text/javascript">
            $(document).ready(function () {
                $('#myTable1').DataTable({
                    fixedHeader: true
                });
                $('#myTable2').DataTable({
                    fixedHeader: true
                });
                $('#myTable3').DataTable({
                    fixedHeader: true,
                    "order": [[ 0, "desc" ]]
                });
            });
            
            function confirmDisable() {
                if (confirm("Are you sure you want to disable this item?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmDelete() {
                if (confirm("Are you sure you want to completely delete this item?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmSubmit() {
                if (confirm("Are you sure you want to submit this request?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmCancel() {
                if (confirm("Are you sure you want to cancel this request?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmTreat() {
                if (confirm("Request will be immediately mapped to your region.\nAre you sure you want to treat this request?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmMarkAsAssigned() {
                if (confirm("Marking this request as assigned will notify the client and assigned commander(s).\nYou may want to review your resource assignments before moving ahead.\nAre you sure you want to continue?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmStart() {
                if (confirm("Are you sure you want to start this task?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmComplete() {
                if (confirm("Are you sure you want to complete this task?")) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>

        <!-- Styles -->
        
    </head>
    <?php
    $more = "";
    if (isset($nest)) {
        for ($i=0; $i<$nest; $i++) {
            $more .= "../";
        }
    }
    
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
    <body style="background-color: #f6f7fb;">
        <div class="container-fluid" style="height: 100vh;">
            <div class="row bg-primary">
                <div class="col-md-6">
                    <div class="text-white float-left" style="display: flex; align-items: center; justify-content: center;">
                        {{ Html::image('images/logo-new-small.jpg', 'Halogen Logo', ['width' => 60]) }}&nbsp;&nbsp;
                        <h4><span class="font-weight-bold">Halo</span>Pivot - {{ config('app.name') }}</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="float-right text-white" style="display: flex; align-items: center; justify-content: center; height: 100%;">
                        {{ $halo_user->username }}
                    </div>
                </div>
            </div>
            <div class="row bg-secondary">
                <div class="col-12" style="height: 10px;">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="page-header" style="border-bottom: 1px solid #999; padding: 30px 0; margin-bottom: 20px; color: #999;">Taskboard - {{ $region->name }} Region</h1>
                </div>
            </div>
            @include('commons.message')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body bg-white" style="padding: 20px;">
                            <table class="display-1 table table-condensed table-hover table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th width="10%"><strong>PICKUP/SERVICE DATE/TIME</strong></th>
                                        <th><strong>CLIENT INFORMATION</strong></th>
                                        <th width="15%"><strong>PRINCIPAL'S DETAILS</strong></th>
                                        <th width="15%"><strong>PICKUP/SERVICE LOCATION</strong></th>
                                        <th width="15%"><strong>STOPS</strong></th>
                                        <th width="15%"><strong>COMMANDER(S)</strong></th>
                                        <th width="10%"><strong>STATUS</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\AmdRequest::where('region_id', $region->id)->whereRaw('status_id in (2,4,5)')->get() as $request)

                                    <tr>
                                        <td>{{ $request->service_date_time }}</td>
                                        <td>{{ $request->client->name }}<br />{{ $request->client->mobile_no }}<br />{{ $request->client->email }}</td>
                                        <td>{{ $request->principal_name }}<br />{{ $request->principal_mobile_no }}<br />{{ $request->principal_email }}</td>
                                        <td>{{ $request->service_location }}</td>
                                        <td>
                                            @foreach (App\AmdRequestStop::where('request_id', $request->id)->get() as $stop)
                                            {{ $stop->address }}<br />
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach (App\AmdResource::where('request_id', $request->id)->where('resource_type', 1)->get() as $resource)
                                            {{ App\AmdUser::whereId($resource->resource_id)->first()->name }}<br />
                                            @endforeach
                                        </td>
                                        <td>
                                            <h4><span class="badge @if ($request->status_id == 2) badge-danger @elseif ($request->status_id == 4) badge-warning @elseif ($request->status_id == 5) badge-success @endif bad">{{ $request->status->description }}</span></h4>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 justify-content-end text-right">
                    <div style="border-top: 1px solid #999; margin-top: 20px; padding: 10px 0;">Powered by <a href="https://halogensecurity.com" target="_blank">Strategy Hub | Halogen Security Company</a></div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Select Region</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hover">
                            @foreach (App\AmdRegion::where('active', true)->get() as $region)
                            <tr>
                                <td width="60%">{{ $region->name }}</td>
                                <td><a class="btn btn-primary" href="{{ route('taskboard', $region->slug()) }}"><i class="fas fa-eye"></i> View Task Board</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>
