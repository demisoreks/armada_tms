<div class="form-group row">
    {!! Form::label('resource_type', 'Resource Type *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('resource_type', [0 => 'Vehicle', 1 => 'Commander'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row vh" style="display: none;">
    {!! Form::label('vehicle_type_id', 'Vehicle Type *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('vehicle_type_id', App\AmdVehicleType::where('active', true)->orderBy('description')->pluck('description', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row vh" style="display: none;">
    {!! Form::label('vehicle_id', 'Vehicle *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('vehicle_id', [], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -']) !!}
    </div>
</div>
<div class="form-group row" id="cm" style="display: none;">
    {!! Form::label('user_id', 'Commander *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('user_id', App\AmdUser::whereRaw('employee_id in ('.implode(',', App\AccEmployeeRole::where('role_id', App\AccRole::where('privileged_link_id', DB::table('amd_config')->whereId(1)->first()->link_id)->where('title', 'Commander')->first()->id)->pluck('employee_id')->toArray()).')')->where('region_id', App\AmdUser::where('employee_id', $halo_user->id)->first()->region_id)->orderBy('name')->pluck('name', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -']) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('start_date_time', 'Start Date/Time *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::date('start_date', $value = null, ['class' => 'form-control', 'required' => true]) !!}
        {!! Form::time('start_time', $value = null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('end_date_time', 'End Date/Time *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::date('end_date', $value = null, ['class' => 'form-control', 'required' => true]) !!}
        {!! Form::time('end_time', $value = null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<script type="text/javascript">
    $('#resource_type').change(function() {
        var resource_type = $("#resource_type").val();
        if (resource_type === '0') {
            $(".vh").slideDown(1000);
            $("#cm").slideUp(1000);
            $("#vehicle_type_id").attr("required", true);
            $("#vehicle_id").attr("required", true);
            $("#user_id").attr("required", false);
        } else if (resource_type === '1') {
            $(".vh").slideUp(1000);
            $("#cm").slideDown(1000);
            $("#vehicle_type_id").attr("required", false);
            $("#vehicle_id").attr("required", false);
            $("#user_id").attr("required", true);
        } else {
            $(".vh").slideUp(1000);
            $("#cm").slideUp(1000);
            $("#vehicle_type_id").attr("required", false);
            $("#vehicle_id").attr("required", false);
            $("#user_id").attr("required", false);
        }
    });
    
    $(document).ready(function() {
        $("#vehicle_type_id").change(function() {
            document.getElementById('vehicle_id').length = 1;
            var vehicle_type_id = $("#vehicle_type_id").val();
            var myString = "";
            
            var ajaxRequest = null;
            
            var browser = navigator.appName;
            if (browser == "Microsoft Internet Explorer") {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } else {
                ajaxRequest = new XMLHttpRequest();
            }
            
            ajaxRequest.onreadystatechange = function() {
                if (ajaxRequest.readyState == 4) {
                    var json_object = JSON.parse(ajaxRequest.responseText);
                    for (var key in json_object) {
                        if (json_object.hasOwnProperty(key)) {
                            $("#vehicle_id").append("<option value="+json_object[key].id+">"+json_object[key].plate_number+" ("+json_object[key].driver+")</option>");
                        }
                    }
                }
            }
            
            ajaxRequest.open("GET", "../vehicle_types/"+vehicle_type_id+"/get_vehicles", true);
            ajaxRequest.send(null);
        });
    });
</script>