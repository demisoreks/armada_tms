@extends('app', ['page_title' => 'Ratings', 'open_menu' => 'analytics'])

@section('content')
<div class="row" style="margin-bottom: 20px;">
    <div class="col-12">
        {!! Form::model($param, ['route' => ['analytics.ratings'], 'class' => 'form-inline']) !!}
            @include('analytics/date_form', ['submit_text' => 'Search'])
        {!! Form::close() !!}
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>AVERAGE COMMANDER RATINGS</strong>
            </div>
            <div class="card-body bg-white">
                <table id="myTable1" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>COMMANDER</strong></th>
                            <th width="40%"><strong>REGION</strong></th>
                            <th width="20%"><strong>AVERAGE</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ratings as $rating)
                        <tr>
                            <td>{{ $rating['commander'] }}</td>
                            <td>{{ $rating['region'] }}</td>
                            <td align="right">{{ $rating['average'] }}</td>
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
                <strong>OVERALL RATINGS</strong>
            </div>
            <div class="card-body bg-white">
                
            </div>
        </div>
    </div>
</div>
@endsection