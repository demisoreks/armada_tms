<div class="form-group row">
    {!! Form::label('entry_time', 'Entry Time *', ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        <input type="datetime-local" id="entry_time" name="entry_time" class="form-control" required>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('exit_time', 'Exit Time *', ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        <input type="datetime-local" id="exit_time" name="exit_time" class="form-control" required>
    </div>
</div>
@foreach (App\AmdErsChecklist::where('patrol', true)->get() as $check)
@if ($check->clients == null || $check->clients == "" || in_array($ers_location->client_id, explode(',', $check->clients)))
<div class="form-group row">
    {!! Form::label($check->id, $check->description, ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        @if ($check->options == null || $check->options == "")
        {!! Form::text($check->id, $value = null, ['class' => 'form-control', 'placeholder' => 'Type here', 'maxlength' => 1000, 'required' => true]) !!}
        @else
        {!! Form::select($check->id, array_combine(explode(',', $check->options), explode(',', $check->options)), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
        @endif
    </div>
</div>
@endif
@endforeach
<div class="form-group row">
    <div class="col-md-12">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
