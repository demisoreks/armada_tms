<div class="form-group row">
    {!! Form::label('other_requirement_type', 'Requirement Type *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('other_requirement_type', [0 => 'Vehicle', 1 => 'Commander', 2 => 'Police'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row" id="vt" style="display: none;">
    {!! Form::label('vehicle_type_id', 'Vehicle Type *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('vehicle_type_id', App\AmdVehicleType::where('active', true)->orderBy('description')->pluck('description', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -']) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('quantity', 'Quantity *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::number('quantity', $value = null, ['class' => 'form-control', 'placeholder' => 'Quantity', 'required' => true, 'maxlength' => 20]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<script type="text/javascript">
    $("#other_requirement_type").change(function() {
        var requirement_type = $(this).val();
        if (requirement_type === '0') {
            $("#vt").slideDown(1000);
            $("#vehicle_type_id").attr('required', true);
        } else {
            $("#vt").slideUp(1000);
            $("#vehicle_type_id").attr('required', false);
        }
    });
</script>