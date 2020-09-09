<div class="form-group row">
    {!! Form::label('entry_time', 'Entry Time *', ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        <input type="datetime-local" id="entry_time" name="entry_time" class="form-control" required @if (isset($visit)) value="{{ str_replace(" ", "T", $visit->entry_time) }}" @endif>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('exit_time', 'Exit Time *', ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        <input type="datetime-local" id="exit_time" name="exit_time" class="form-control" required @if (isset($visit)) value="{{ str_replace(" ", "T", $visit->exit_time) }}" @endif>
    </div>
</div>
@foreach (App\AmdErsChecklist::where('response', true)->get() as $check)
@if ($check->clients == null || $check->clients == "" || in_array($request->client_id, explode(',', $check->clients)))
<?php
$val = null;
if (isset($visit)) {
    if (App\AmdErsVisitDetail::where('ers_visit_id', $visit->id)->where('description', $check->description)->count() > 0) {
        $val = App\AmdErsVisitDetail::where('ers_visit_id', $visit->id)->where('description', $check->description)->first()->option;
    }
}
?>
<div class="form-group row">
    {!! Form::label($check->id, $check->description, ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        @if ($check->options == null || $check->options == "")
        {!! Form::text($check->id, $value = $val, ['class' => 'form-control', 'placeholder' => 'Type here', 'maxlength' => 1000, 'required' => true]) !!}
        @else
        {!! Form::select($check->id, array_combine(explode(',', $check->options), explode(',', $check->options)), $value = $val, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
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
