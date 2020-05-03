<?php
use GuzzleHttp\Client;
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $page_title }} | {{ config('app.name') }}</title>
        
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
        {!! Html::style('css/responsive.dataTables.min.css') !!}
        {!! Html::style('css/buttons.dataTables.min.css') !!}
        {!! Html::style('fontawesome/css/all.css') !!}
        
        {!! Html::script('js/jquery-3.3.1.min.js') !!}
        {!! Html::script('js/popper.min.js') !!}
        {!! Html::script('js/app.js') !!}
        {!! Html::script('js/mdb.min.js') !!}
        {!! Html::script('js/datatables.min.js') !!}
        {!! Html::script('js/dataTables.responsive.min.js') !!}
        {!! Html::script('js/dataTables.buttons.min.js') !!}
        {!! Html::script('js/buttons.flash.min.js') !!}
        {!! Html::script('js/jszip.min.js') !!}
        {!! Html::script('js/pdfmake.min.js') !!}
        {!! Html::script('js/vfs_fonts.js') !!}
        {!! Html::script('js/buttons.html5.min.js') !!}
        {!! Html::script('js/buttons.print.min.js') !!}
        
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
                $('#myTable4').DataTable({
                    fixedHeader: true,
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'print'
                    ]
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
                    <h1 class="page-header" style="border-bottom: 1px solid #999; padding: 30px 0; margin-bottom: 20px; color: #999;">{{ $page_title }}</h1>
                </div>
            </div>
            @include('commons.message')
            <div class="row">
                <div class="col-md-2">
                    <div id="accordion-menu" style="margin-bottom: 10px;">
                        <div class="card">
                            <div class="card-header bg-white" id="heading-menu1" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-menu1" aria-expanded="true" aria-controls="collapse-menu1">
                                        <strong>General</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse-menu1" class="collapse @if (!isset($open_menu)) show @endif" aria-labelledby="heading-menu1" data-parent="#accordion-menu">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="{{ route('welcome') }}">Home</a>
                                        <a class="nav-link" href="#" data-toggle="modal" data-target="#modal1">Task Board</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        @if (count(array_intersect($permissions, ['Supervisor'])) != 0)
                        <div class="card">
                            <div class="card-header bg-white" id="heading-menu5" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-menu6" aria-expanded="true" aria-controls="collapse-menu6">
                                        <strong>Analytics</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse-menu6" class="collapse @if (isset($open_menu) && $open_menu == 'analytics') show @endif" aria-labelledby="heading-menu6" data-parent="#accordion-menu">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="{{ route('analytics.ratings') }}">Ratings</a>
                                        <a class="nav-link" href="{{ route('analytics.feedbacks') }}">Feedbacks</a>
                                        <a class="nav-link" href="{{ route('analytics.status') }}">Request Status</a>
                                        <a class="nav-link" href="{{ route('analytics.directory') }}">Request Directory</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        @endif
                        @if (count(array_intersect($permissions, ['Commander','Detailer'])) != 0)
                        <div class="card">
                            <div class="card-header bg-white" id="heading-menu5" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-menu5" aria-expanded="true" aria-controls="collapse-menu5">
                                        <strong>Task Mgt.</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse-menu5" class="collapse @if (isset($open_menu) && $open_menu == 'task') show @endif" aria-labelledby="heading-menu5" data-parent="#accordion-menu">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        @if (count(array_intersect($permissions, ['Commander'])) != 0)
                                        <a class="nav-link" href="{{ route('requests.assigned') }}">My Tasks</a>
                                        @endif
                                        @if (count(array_intersect($permissions, ['Detailer'])) != 0)
                                        <a class="nav-link" href="{{ route('requests.submitted') }}">Detailing</a>
                                        @endif
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        @endif
                        @if (count(array_intersect($permissions, ['Admin','Detailer'])) != 0)
                        <div class="card">
                            <div class="card-header bg-white" id="heading-menu4" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-menu4" aria-expanded="true" aria-controls="collapse-menu4">
                                        <strong>Client Mgt.</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse-menu4" class="collapse @if (isset($open_menu) && $open_menu == 'client') show @endif" aria-labelledby="heading-menu4" data-parent="#accordion-menu">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="{{ route('clients.index') }}">Clients</a>
                                        <a class="nav-link" href="{{ route('requests.index') }}">Service Requests</a>
                                        <!--<a class="nav-link" href="#">Invoicing</a>-->
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        @endif
                        @if (count(array_intersect($permissions, ['Detailer'])) != 0)
                        <div class="card">
                            <div class="card-header bg-white" id="heading-menu3" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-menu3" aria-expanded="true" aria-controls="collapse-menu3">
                                        <strong>Resource Mgt.</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse-menu3" class="collapse @if (isset($open_menu) && $open_menu == 'resource') show @endif" aria-labelledby="heading-menu3" data-parent="#accordion-menu">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="{{ route('regions.vehicles.index', App\AmdRegion::whereId(App\AmdUser::where('employee_id', $halo_user->id)->first()->region_id)->first()->slug()) }}">Vehicles</a>
                                        <a class="nav-link" href="{{ route('downtimes.index') }}">Resource Downtime</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        @endif
                        @if (count(array_intersect($permissions, ['Admin'])) != 0)
                        <div class="card">
                            <div class="card-header bg-white" id="heading-menu2" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-menu2" aria-expanded="true" aria-controls="collapse-menu2">
                                        <strong>Admin</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse-menu2" class="collapse @if (isset($open_menu) && $open_menu == 'admin') show @endif" aria-labelledby="heading-menu2" data-parent="#accordion-menu">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="{{ route('services.index') }}">Services</a>
                                        <a class="nav-link" href="{{ route('vehicle_types.index') }}">Vehicle Types</a>
                                        <a class="nav-link" href="{{ route('vendors.index') }}">Vendors</a>
                                        <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                                        <a class="nav-link" href="{{ route('states.index') }}">States</a>
                                        <a class="nav-link" href="{{ route('regions.index') }}">Regions</a>
                                        <a class="nav-link" href="{{ route('config') }}">Configuration</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        @endif
                        @if (count(array_intersect($permissions, ['ControlRoom', 'Supervisor', 'Admin'])) != 0)
                        <div class="card">
                            <div class="card-header bg-white" id="heading-menu7" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-menu7" aria-expanded="true" aria-controls="collapse-menu7">
                                        <strong>ERS Menu</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse-menu7" class="collapse @if (isset($open_menu) && $open_menu == 'ers') show @endif" aria-labelledby="heading-menu7" data-parent="#accordion-menu">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        @if (count(array_intersect($permissions, ['ControlRoom'])) != 0)
                                        <a class="nav-link" href="{{ route('ers_clients.pending') }}">Pending Clients</a>
                                        @endif
                                        <a class="nav-link" href="{{ route('ers_clients.active') }}">Active Clients</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body bg-white" style="padding: 20px;">
                            @yield('content')
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
                                <td><a class="btn btn-primary" href="{{ route('taskboard', $region->slug()) }}" target="_blank"><i class="fas fa-eye"></i> View Task Board</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>
