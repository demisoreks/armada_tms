<div class="form-group row">
    {!! Form::label('situation_id', 'Situation *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::select('situation_id', App\AmdSituation::where('active', true)->orderBy('description')->pluck('description', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('location', 'Location *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::text('location', $value = null, ['class' => 'form-control controls search', 'placeholder' => 'Location (Full Address)', 'required' => true, 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('close_landmark', 'Close Landmark', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::text('close_landmark', $value = null, ['class' => 'form-control', 'placeholder' => 'Close Landmark', 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('remarks', 'Additional Remarks', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('remarks', $value = null, ['class' => 'form-control', 'placeholder' => 'Additional Remarks', 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-4">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>