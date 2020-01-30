@extends('app', ['page_title' => 'Request Status', 'open_menu' => 'analytics'])

@section('content')
<div class="row" style="margin-bottom: 20px;">
    <div class="col-12">
        {!! Form::model($param, ['route' => ['analytics.status'], 'class' => 'form-inline']) !!}
            <div class="col-auto">
                {!! Form::label('search_by', 'Search By', []) !!}
            </div>
            <div class="col-auto">
                {!! Form::select('search_by', ['service_date_time' => 'Service Date', 'created_at' => 'Creation Date'], $value = null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
            @include('analytics/date_form', ['submit_text' => 'Search'])
        {!! Form::close() !!}
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>STATUS COUNTS</strong>
            </div>
            <div class="card-body bg-white">
                <table id="myTable4" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th width="15%" data-priority="1"><strong>S/N</strong></th>
                            <th data-priority="1"><strong>STATUS</strong></th>
                            <th width="30%" data-priority="1"><strong>COUNT</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($status as $s)
                        <tr>
                            <td>{{ $s['sn'] }}</td>
                            <td>{{ $s['status'] }}</td>
                            <td align="right">{{ $s['count'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>STATUS DISTRIBUTION</strong>
            </div>
            <div class="card-body bg-white">
                {!! $status_chart->container() !!}
                {!! $status_chart->script() !!}
            </div>
        </div>
    </div>
</div>
@endsection