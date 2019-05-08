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
                                        <strong>Task Mgt</strong>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse-menu1" class="collapse @if (!isset($open_menu)) show @endif" aria-labelledby="heading-menu1" data-parent="#accordion-menu">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="{{ route('welcome') }}">Task Board</a>
                                        @if (count(array_intersect($permissions, ['Commander'])) != 0)
                                        <a class="nav-link" href="#">My Tasks</a>
                                        @endif
                                        @if (count(array_intersect($permissions, ['Supervisor'])) != 0)
                                        <a class="nav-link" href="#">Anayltics</a>
                                        @endif
                                    </nav>
                                </div>
                            </div> 
                        </div>
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
                                        <a class="nav-link" href="#">Configuration</a>
                                        <a class="nav-link" href="{{ route('regions.index') }}">Regions</a>
                                        <a class="nav-link" href="{{ route('users.index') }}">Users</a>
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
    </body>
</html>
