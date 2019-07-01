<div class="form-group row">
    {!! Form::label('interested', 'Principal Interested? *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::select('interested', ['No' => 'No', 'Yes' => 'Yes'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div id="fdb" style="display: none;">
<div class="form-group row">
    <div class="col-12 text-info">
        This section must be completed by the Principal. Any fowl play will be regarded as a serious offense.
    </div>
</div>
<div class="form-group row">
    {!! Form::label('rating', 'Rating *', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::select('rating', [5 => '5 - Excellent', 4 => '4 - Good', 3 => '3 - Satisfactory', 2 => '2 - Poor', 1 => '1 - Very Poor'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -']) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('feedback', 'Feedback', ['class' => 'col-md-4 col-form-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('feedback', $value = null, ['class' => 'form-control', 'placeholder' => 'Feedback', 'maxlength' => 1000]) !!}
    </div>
</div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-4">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<script type="text/javascript">
    $("#interested").change(function() {
        if ($(this).val() === "Yes") {
            $("#fdb").slideDown(1000);
            $("#rating").attr("required", true);
        } else {
            $("#fdb").slideUp(1000);
            $("#rating").attr("required", false);
        }
    });
</script>