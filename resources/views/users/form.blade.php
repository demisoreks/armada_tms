<div class="form-group row">
    {!! Form::label('username', 'Username *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('username', $user->username, ['class' => 'form-control', 'placeholder' => 'Username', 'required' => true, 'maxlength' => 100, 'readonly' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('name', 'Code Name *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Code Name', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('email', 'Email Address *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('email', $value = null, ['class' => 'form-control', 'placeholder' => 'Email Address', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('region_id', 'Region *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('region_id', App\AmdRegion::where('active', true)->orderBy('name')->pluck('name', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>