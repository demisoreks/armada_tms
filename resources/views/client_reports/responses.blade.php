<?php
use GuzzleHttp\Client;
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Response Report | {{ config('app.name') }}</title>

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
        {!! Html::style('css/select2.min.css') !!}

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
        {!! Html::script('js/select2.min.js') !!}

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
                        {{ $client->name }}
                    </div>
                </div>
            </div>
            <div class="row bg-secondary">
                <div class="col-12" style="height: 10px;">

                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="page-header" style="border-bottom: 1px solid #999; padding: 30px 0; margin-bottom: 20px; color: #999;">Response Report</h1>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-12">
                    {!! Form::model($param, ['route' => ['reports.clients.responses', $client->slug()], 'class' => 'form-inline']) !!}
                        @include('analytics/date_form', ['submit_text' => 'Search'])
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="margin-bottom: 20px;">
                        <div class="card-header bg-white">
                            <strong>COMPLETED TASKS</strong>
                        </div>
                        <div class="card-body bg-white">
                            <table id="myTable4" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th><strong>RESPONSE DATE/TIME</strong></th>
                                        <th><strong>REFERENCE NO.</strong></th>
                                        <th><strong>LOCATION</strong></th>
                                        <th><strong>ENTRY DATE/TIME</strong></th>
                                        <th><strong>EXIT DATE/TIME</strong></th>
                                        <th><strong>INCIDENT(S)</strong></th>
                                        <th><strong>CHECKLIST</strong></th>
                                        <th><strong>COMMANDER</strong></th>
                                        <th><strong>WATCHKEEPER'S COMMENT</strong></th>
                                        <th><strong>WATCHKEEPER</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)

                                    <tr>
                                        <td>{{ $request->service_date_time }}</td>
                                        <td>HAL/ERS/{{ sprintf('%05d', $request->id) }}</td>
                                        <td>{{ $request->principal_name }}</td>
                                        <td>{{ App\AmdErsVisit::where('request_id', $request->id)->first()->entry_time }}</td>
                                        <td>{{ App\AmdErsVisit::where('request_id', $request->id)->first()->exit_time }}</td>
                                        <td>
                                            @foreach (App\AmdIncident::where('request_id', $request->id)->get() as $incident)
                                            <strong>Incident Type:</strong> {{ $incident->incidentType->description }}<br />
                                            <strong>Incident Date/Time:</strong> {{ Carbon\Carbon::parse($incident->incident_date_time)->format('l, F j, Y g:i a') }}<br />
                                            <strong>Description:</strong> {{ $incident->description }}<br />
                                            <strong>Action Taken:</strong> {{ $incident->action_taken }}<br />
                                            <strong>Follow-up Action:</strong> {{ $incident->follow_up_action }}<br />
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach (App\AmdErsVisitDetail::where('ers_visit_id', App\AmdErsVisit::where('request_id', $request->id)->first()->id)->get() as $detail)
                                            <strong>{{ $detail->description }}:</strong>{{ $detail->option }}<br />
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($request->user_id) {{ App\AmdUser::find($request->user_id)->full_name }} @endif
                                        </td>
                                        <td>
                                            {{ $request->detailer_review }}
                                        </td>
                                        <td>
                                            @if ($request->detailer_user_id) {{ App\AmdUser::find($request->detailer_user_id)->full_name }} @endif
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
                    <div style="border-top: 1px solid #999; margin-top: 20px; padding: 10px 0;">Powered by <a href="https://halogensecurity.com" target="_blank">Halogen Security Company</a></div>
                </div>
            </div>
        </div>
    </body>
</html>
