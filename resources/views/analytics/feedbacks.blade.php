@extends('app', ['page_title' => 'Feedbacks', 'open_menu' => 'analytics'])

@section('content')
<div class="row" style="margin-bottom: 20px;">
    <div class="col-12">
        {!! Form::model($param, ['route' => ['analytics.feedbacks'], 'class' => 'form-inline']) !!}
            @include('analytics/date_form', ['submit_text' => 'Search'])
        {!! Form::close() !!}
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>ALL REQUESTS</strong>
            </div>
            <div class="card-body bg-white">
                <table id="myTable4" class="display-1 table table-condensed table-hover table-striped responsive" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th data-priority="1" width="15%"><strong>PICKUP/SERVICE DATE/TIME</strong></th>
                            <th data-priority="1" width="25%"><strong>CLIENT INFO</strong></th>
                            <th width="10%"><strong>COMMANDER(S)</strong></th>
                            <th width="10%"><strong>RATING</strong></th>
                            <th><strong>FEEDBACK</strong></th>
                            <th data-priority="1" width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                        <tr>
                            <td>{{ $request->service_date_time }}</td>
                            <td>{{ $request->client->name }}&nbsp;<br />{{ $request->client->mobile_no }}&nbsp;<br />{{ $request->client->email }}</td>
                            <td>
                                @foreach (App\AmdResource::where('request_id', $request->id)->where('resource_type', 1)->get() as $resource)
                                {{ App\AmdUser::whereId($resource->resource_id)->first()->name }}
                                &nbsp;<br />
                                @endforeach
                            </td>
                            <td align="center">{{ $request->rating }}</td>
                            <td>{{ $request->feedback }}</td>
                            <td>
                                <a class="btn btn-primary btn-block btn-sm" href="{{ route('analytics.details', [$request->slug()]) }}">More Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection