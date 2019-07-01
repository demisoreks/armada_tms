<?php
use GuzzleHttp\Client;
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $page_title }} | Armada Halogen</title>
        
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
    
    if (!isset($_SESSION))
        session_start();
    ?>
    <body style="background-color: #f6f7fb;">
        <div class="container-fluid" style="height: 100vh;">
            <div class="row bg-primary">
                <div class="col-md-6">
                    <div class="text-white float-left" style="display: flex; align-items: center; justify-content: center;">
                        {{ Html::image('images/logo-new-small.jpg', 'Halogen Logo', ['width' => 60]) }}&nbsp;&nbsp;
                        <h4><span class="font-weight-bold">Armada </span>Halogen</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="float-right text-white" style="display: flex; align-items: center; justify-content: center; height: 100%;">
                        <nav class="navbar navbar-expand-lg" style="box-shadow: none;">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main" aria-controls="main" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon text-white"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="main">
                                <div class="navbar-nav">
                                    <a class="nav-item nav-link text-white" href="{{ route('client.index') }}">Home <span class="sr-only">(current)</span></a>
                                    <a class="nav-item nav-link text-white" href="{{ route('client.cart') }}">Cart</a>
                                    <a class="nav-item nav-link text-white" href="#">Requests</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row bg-secondary">
                <div class="col-12" style="height: 10px;">
                    
                </div>
            </div>
            @yield('content')
            <div class="row">
                <div class="col-12 text-center">
                    <nav class="navbar navbar-expand text-center" style="box-shadow: none;">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#foot" aria-controls="foot" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="foot">
                            <div class="navbar-nav">
                                <a class="nav-item nav-link" href="#">Terms &amp Conditions</a>
                                <a class="nav-item nav-link" href="#">Privacy Policy</a>
                                <a class="nav-item nav-link" href="#">FAQ</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12 justify-content-end text-center">
                    <div style="border-top: 1px solid #999; margin-top: 20px; padding: 10px 0;">Copyright &copy; <a href="https://halogensecurity.com" target="_blank">Halogen Group</a></div>
                </div>
            </div>
        </div>
    </body>
</html>
