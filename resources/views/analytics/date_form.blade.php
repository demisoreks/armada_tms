<div class="form-row align-items-center">
    <div class="col-auto">
        {!! Form::label('from_date', 'From', []) !!}
    </div>
    <div class="col-auto">
        {!! Form::date('from_date', $value = null, ['class' => 'form-control', 'placeholder' => 'From Date', 'required' => true]) !!}
    </div>
    <div class="col-auto">
        {!! Form::label('to_date', 'To', []) !!}
    </div>
    <div class="col-auto">
        {!! Form::date('to_date', $value = null, ['class' => 'form-control', 'placeholder' => 'To Date', 'required' => true]) !!}
    </div>
    <div class="col-auto">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary btn-sm']) !!}
    </div>
</div>