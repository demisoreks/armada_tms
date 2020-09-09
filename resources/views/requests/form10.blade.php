<div class="form-group row">
    {!! Form::label('incident_type_id', 'Incident Type *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::select('incident_type_id', App\AmdIncidentType::where('active', true)->pluck('description', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Incident Type -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('incident_date_time', 'Incident Date/Time *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        <input type="datetime-local" id="incident_date_time" name="incident_date_time" class="form-control" required>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('description', 'Description', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('description', $value = null, ['class' => 'form-control', 'placeholder' => 'Description', 'maxlength' => 1000, 'rows' => 3]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('action_taken', 'Action Taken', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('action_taken', $value = null, ['class' => 'form-control', 'placeholder' => 'Action Taken', 'maxlength' => 1000, 'rows' => 3]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('follow_up_action', 'Follow-Up Action', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('follow_up_action', $value = null, ['class' => 'form-control', 'placeholder' => 'Follow-Up Action', 'maxlength' => 1000, 'rows' => 3]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-4">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
