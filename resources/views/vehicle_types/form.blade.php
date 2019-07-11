<div class="form-group row">
    {!! Form::label('description', 'Description *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('description', $value = null, ['class' => 'form-control', 'placeholder' => 'Description', 'required' => true, 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('features', 'Features', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea('features', $value = null, ['class' => 'form-control', 'placeholder' => 'Features', 'maxlength' => 10000]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('pick_and_drop_cost', 'Pick/Drop Cost', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::number('pick_and_drop_cost', $value = null, ['class' => 'form-control', 'placeholder' => 'Pick/Drop Cost', 'maxlength' => 20, 'step' => '0.01']) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('average_daily_cost', 'Average Daily Cost', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::number('average_daily_cost', $value = null, ['class' => 'form-control', 'placeholder' => 'Average Daily Cost', 'maxlength' => 20, 'step' => '0.01']) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>