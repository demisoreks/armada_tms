<div class="form-group row">
    {!! Form::label('detailer_review', 'Detailer Review *', ['class' => 'col-md-12 col-form-label']) !!}
    <div class="col-md-12">
        {!! Form::textarea('detailer_review', $value = null, ['class' => 'form-control', 'placeholder' => 'Comments', 'maxlength' => 1000, 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
