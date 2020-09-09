<div class="form-group row">
    {!! Form::label('name', 'Name *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Name', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('client_id', 'Client *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('client_id', App\AmdClient::where('active', true)->orderBy('name')->pluck('name', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('address', 'Address', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('address', $value = null, ['class' => 'form-control controls search', 'placeholder' => 'Address', 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('latitude', 'Latitude', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('latitude', $value = null, ['class' => 'form-control', 'placeholder' => 'Latitude', 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('longitude', 'Longitude', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('longitude', $value = null, ['class' => 'form-control', 'placeholder' => 'Longitude', 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<div id="map" hidden></div>

<script src="{{ "https://maps.googleapis.com/maps/api/js?key=".App\AmdConfig::whereId(1)->first()->google_places_api_key."&libraries=places&callback=initAutocomplete" }}" async defer></script>
<script>
function initAutocomplete() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -33.8688, lng: 151.2195},
    zoom: 13,
    mapTypeId: 'roadmap'
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('service_location');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Create the search box and link it to the UI element.
  var input2 = document.getElementById('address');
  var searchBox2 = new google.maps.places.SearchBox(input2);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input2);
}
</script>
