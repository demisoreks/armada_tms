@extends('app', ['page_title' => 'Configuration', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12">
        <legend>Edit Configuration</legend>
        {!! Form::model($config, ['route' => ['config.update'], 'class' => 'form-group']) !!}
        @method('PUT')
            <div class="form-group row">
                {!! Form::label('link_id', 'Link ID *', ['class' => 'col-md-2 col-form-label']) !!}
                <div class="col-md-4">
                    {!! Form::number('link_id', $value = null, ['class' => 'form-control', 'placeholder' => 'Link ID', 'required' => true, 'maxlength' => 20]) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('commander_daily_cost', 'Commander Cost *', ['class' => 'col-md-2 col-form-label']) !!}
                <div class="col-md-4">
                    {!! Form::number('commander_daily_cost', $value = null, ['class' => 'form-control', 'placeholder' => 'Commander Daily Cost', 'required' => true, 'maxlength' => 20, 'step' => '0.01']) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('police_daily_cost', 'Police Cost *', ['class' => 'col-md-2 col-form-label']) !!}
                <div class="col-md-4">
                    {!! Form::number('police_daily_cost', $value = null, ['class' => 'form-control', 'placeholder' => 'Police Daily Cost', 'required' => true, 'maxlength' => 20, 'step' => '0.01']) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('google_places_api_key', 'Google Places API Key *', ['class' => 'col-md-2 col-form-label']) !!}
                <div class="col-md-4">
                    {!! Form::text('google_places_api_key', $value = null, ['class' => 'form-control', 'placeholder' => 'Google Places API Key', 'required' => true, 'maxlength' => 150]) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('er_email', 'ER Email(s)', ['class' => 'col-md-2 col-form-label']) !!}
                <div class="col-md-4">
                    {!! Form::textarea('er_email', $value = null, ['class' => 'form-control', 'placeholder' => 'ER Email(s)', 'required' => true, 'maxlength' => 100]) !!}
                    <small>Multiple emails should be separated by commas.</small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 offset-md-2">
                    {!! Form::submit('Update Configuration', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
