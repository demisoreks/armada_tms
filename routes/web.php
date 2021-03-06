<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$link_id = DB::table('amd_config')->whereId(1)->first()->link_id;

Route::get('/', [
    'as' => 'welcome', 'uses' => 'WelcomeController@index'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer,Commander,Supervisor,ControlRoom']);
Route::get('thank_you', [
    'as' => 'thank_you', 'uses' => 'WelcomeController@thank_you'
]);
Route::get('taskboard/{region}', [
    'as' => 'taskboard', 'uses' => 'WelcomeController@taskboard'
]);

Route::get('regions/{region}/disable', [
    'as' => 'regions.disable', 'uses' => 'RegionsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('regions/{region}/enable', [
    'as' => 'regions.enable', 'uses' => 'RegionsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('regions', 'RegionsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('regions', function($value, $route) {
    return App\AmdRegion::findBySlug($value)->first();
});

Route::resource('states', 'StatesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('states', function($value, $route) {
    return App\AmdState::findBySlug($value)->first();
});

Route::resource('users', 'UsersController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('users', function($value, $route) {
    return App\AmdUser::findBySlug($value)->first();
});

Route::get('vehicle_types/{vehicle_type_id}/get_vehicles', [
    'as' => 'vehicle_types.get_vehicles', 'uses' => 'VehicleTypesController@get_vehicles'
]);
Route::get('vehicle_types/{vehicle_type}/disable', [
    'as' => 'vehicle_types.disable', 'uses' => 'VehicleTypesController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('vehicle_types/{vehicle_type}/enable', [
    'as' => 'vehicle_types.enable', 'uses' => 'VehicleTypesController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('vehicle_types', 'VehicleTypesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('vehicle_types', function($value, $route) {
    return App\AmdRegion::findBySlug($value)->first();
});

Route::get('vendors/{vendor}/disable', [
    'as' => 'vendors.disable', 'uses' => 'VendorsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('vendors/{vendor}/enable', [
    'as' => 'vendors.enable', 'uses' => 'VendorsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('vendors', 'VendorsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('vendors', function($value, $route) {
    return App\AmdVendor::findBySlug($value)->first();
});

Route::get('regions/{region}/vehicles/{vehicle}/disable', [
    'as' => 'regions.vehicles.disable', 'uses' => 'VehiclesController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::get('regions/{region}/vehicles/{vehicle}/enable', [
    'as' => 'regions.vehicles.enable', 'uses' => 'VehiclesController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::resource('regions.vehicles', 'VehiclesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::bind('vehicles', function($value, $route) {
    return App\AmdVehicle::findBySlug($value)->first();
});

Route::get('vehicles/tracking', [
    'as' => 'vehicles.tracking', 'uses' => 'VehiclesController@tracking'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer,Admin,Supervisor,ControlRoom']);
Route::get('vehicles/{vehicle}/track', [
    'as' => 'vehicles.track', 'uses' => 'VehiclesController@track'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer,Admin,Supervisor,ControlRoom']);

Route::get('clients/{client}/disable', [
    'as' => 'clients.disable', 'uses' => 'ClientsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::get('clients/{client}/enable', [
    'as' => 'clients.enable', 'uses' => 'ClientsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::resource('clients', 'ClientsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::bind('clients', function($value, $route) {
    return App\AmdClient::findBySlug($value)->first();
});

Route::get('services/{service_id}/get_options', [
    'as' => 'services.get_options', 'uses' => 'ServicesController@get_options'
]);
Route::get('services/{service}/disable', [
    'as' => 'services.disable', 'uses' => 'ServicesController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('services/{service}/enable', [
    'as' => 'services.enable', 'uses' => 'ServicesController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('services', 'ServicesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('services', function($value, $route) {
    return App\AmdService::findBySlug($value)->first();
});

Route::get('services/{service}/options/{option}/disable', [
    'as' => 'services.options.disable', 'uses' => 'OptionsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('services/{service}/options/{option}/enable', [
    'as' => 'services.options.enable', 'uses' => 'OptionsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('services.options', 'OptionsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('options', function($value, $route) {
    return App\AmdOption::findBySlug($value)->first();
});

Route::get('services/{service}/options/{option}/requirements/{requirement}/disable', [
    'as' => 'services.options.requirements.disable', 'uses' => 'RequirementsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('services/{service}/options/{option}/requirements/{requirement}/enable', [
    'as' => 'services.options.requirements.enable', 'uses' => 'RequirementsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('services.options.requirements', 'RequirementsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('requirements', function($value, $route) {
    return App\AmdRequirement::findBySlug($value)->first();
});

Route::get('config', [
    'as' => 'config', 'uses' => 'ConfigController@index'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::put('config/update', [
    'as' => 'config.update', 'uses' => 'ConfigController@update'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);

Route::get('requests/{ers_file}/remove_file', [
    'as' => 'requests.remove_file', 'uses' => 'RequestsController@remove_file'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::post('requests/{request}/upload_file', [
    'as' => 'requests.upload_file', 'uses' => 'RequestsController@upload_file'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::post('requests/{request}/update_checklist', [
    'as' => 'requests.update_checklist', 'uses' => 'RequestsController@update_checklist'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('requests/{incident}/remove_incident', [
    'as' => 'requests.remove_incident', 'uses' => 'RequestsController@remove_incident'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::post('requests/{request}/add_incident', [
    'as' => 'requests.add_incident', 'uses' => 'RequestsController@add_incident'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::match(['get', 'post'], 'requests/{request}/direction', [
    'as' => 'requests.direction', 'uses' => 'RequestsController@direction'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('requests/{request}/retreat', [
    'as' => 'requests.retreat', 'uses' => 'RequestsController@retreat'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::post('requests/{request}/transfer', [
    'as' => 'requests.transfer', 'uses' => 'RequestsController@transfer'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::post('requests/{request}/submit_feedback', [
    'as' => 'requests.submit_feedback', 'uses' => 'RequestsController@submit_feedback'
]);
Route::get('requests/{request}/feedback', [
    'as' => 'requests.feedback', 'uses' => 'RequestsController@feedback'
]);
Route::post('requests/{request}/add_sitrep', [
    'as' => 'requests.add_sitrep', 'uses' => 'RequestsController@add_sitrep'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('requests/{request}/start', [
    'as' => 'requests.start', 'uses' => 'RequestsController@start'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('requests/{request}/complete', [
    'as' => 'requests.complete', 'uses' => 'RequestsController@complete'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('requests/{request}/jmp', [
    'as' => 'requests.jmp', 'uses' => 'RequestsController@jmp'
]);
Route::get('requests/{request}/manage', [
    'as' => 'requests.manage', 'uses' => 'RequestsController@manage'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('requests/{request}/acknowledge', [
    'as' => 'requests.acknowledge', 'uses' => 'RequestsController@acknowledge'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('requests/assigned', [
    'as' => 'requests.assigned', 'uses' => 'RequestsController@assigned'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('requests/{request}/mark_assigned', [
    'as' => 'requests.mark_assigned', 'uses' => 'RequestsController@mark_assigned'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::get('requests/{resource}/remove_resource', [
    'as' => 'requests.remove_resource', 'uses' => 'RequestsController@remove_resource'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::post('requests/{request}/add_resource', [
    'as' => 'requests.add_resource', 'uses' => 'RequestsController@add_resource'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::get('requests/{request}/treat', [
    'as' => 'requests.treat', 'uses' => 'RequestsController@treat'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::get('requests/submitted', [
    'as' => 'requests.submitted', 'uses' => 'RequestsController@submitted'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer,Supervisor']);
Route::get('requests/{request}/cancel', [
    'as' => 'requests.cancel', 'uses' => 'RequestsController@cancel'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::get('requests/{request}/submit', [
    'as' => 'requests.submit', 'uses' => 'RequestsController@submit'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::get('requests/{request_stop}/remove_stop', [
    'as' => 'requests.remove_stop', 'uses' => 'RequestsController@remove_stop'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::post('requests/{request}/add_stop', [
    'as' => 'requests.add_stop', 'uses' => 'RequestsController@add_stop'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::get('requests/{request_option}/remove_service', [
    'as' => 'requests.remove_service', 'uses' => 'RequestsController@remove_service'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::post('requests/{request}/add_service', [
    'as' => 'requests.add_service', 'uses' => 'RequestsController@add_service'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::get('requests/{client}/initiate', [
    'as' => 'requests.initiate', 'uses' => 'RequestsController@initiate'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::resource('requests', 'RequestsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::bind('requests', function($value, $route) {
    return App\AmdRequest::findBySlug($value)->first();
});

Route::resource('downtimes', 'DowntimesController')->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::bind('downtimes', function($value, $route) {
    return App\AmdDowntime::findBySlug($value)->first();
});

Route::match(['get', 'post'], 'analytics/ratings', [
    'as' => 'analytics.ratings', 'uses' => 'AnalyticsController@ratings'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Supervisor']);
Route::match(['get', 'post'], 'analytics/feedbacks', [
    'as' => 'analytics.feedbacks', 'uses' => 'AnalyticsController@feedbacks'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Supervisor']);
Route::match(['get', 'post'], 'analytics/status', [
    'as' => 'analytics.status', 'uses' => 'AnalyticsController@status'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Supervisor']);
Route::match(['get', 'post'], 'analytics/directory', [
    'as' => 'analytics.directory', 'uses' => 'AnalyticsController@directory'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Supervisor']);
Route::get('analytics/{request}/details', [
    'as' => 'analytics.details', 'uses' => 'AnalyticsController@details'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Supervisor']);

Route::get('client', [
    'as' => 'client.index', 'uses' => 'ClientController@index'
]);
Route::get('client/cart', [
    'as' => 'client.cart', 'uses' => 'ClientController@cart'
]);
Route::post('client/update_request', [
    'as' => 'client.update_request', 'uses' => 'ClientController@update_request'
]);

Route::post('ers_clients/{ers_client}/treat', [
    'as' => 'ers_clients.treat', 'uses' => 'ErsClientsController@treat'
])->middleware(['auth.user', 'auth.access:'.$link_id.',ControlRoom']);
Route::post('ers/submit', [
    'as' => 'ers.submit', 'uses' => 'ErsClientsController@submit'
]);
Route::get('ers/enrol', [
    'as' => 'ers.enrol', 'uses' => 'ErsClientsController@enrol'
]);
Route::get('ers_clients/pending', [
    'as' => 'ers_clients.pending', 'uses' => 'ErsClientsController@pending'
])->middleware(['auth.user', 'auth.access:'.$link_id.',ControlRoom']);
Route::get('ers_clients/active', [
    'as' => 'ers_clients.active', 'uses' => 'ErsClientsController@active'
])->middleware(['auth.user', 'auth.access:'.$link_id.',ControlRoom,Supervisor,Admin']);
Route::get('ers_clients/{ers_client}/view', [
    'as' => 'ers_clients.view', 'uses' => 'ErsClientsController@view'
])->middleware(['auth.user', 'auth.access:'.$link_id.',ControlRoom,Supervisor,Admin']);
Route::bind('ers_clients', function($value, $route) {
    return App\AmdErsClient::findBySlug($value)->first();
});

Route::get('ers_locations/{ers_location}/disable', [
    'as' => 'ers_locations.disable', 'uses' => 'ErsLocationsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::get('ers_locations/{ers_location}/enable', [
    'as' => 'ers_locations.enable', 'uses' => 'ErsLocationsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::resource('ers_locations', 'ErsLocationsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer']);
Route::bind('ers_locations', function($value, $route) {
    return App\AmdErsLocation::findBySlug($value)->first();
});

Route::post('incidents/{request}/submit_approval', [
    'as' => 'incidents.submit_approval', 'uses' => 'IncidentsController@submit_approval'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::get('incidents/{request}/approve', [
    'as' => 'incidents.approve', 'uses' => 'IncidentsController@approve'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::get('incidents/review', [
    'as' => 'incidents.review', 'uses' => 'IncidentsController@review'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Detailer']);
Route::bind('incidents', function($value, $route) {
    return App\AmdIncident::findBySlug($value)->first();
});

Route::match(['get', 'post'], 'patrols/{ers_location}/direction', [
    'as' => 'patrols.direction', 'uses' => 'VisitsController@direction'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::post('vists/{ers_location}/store', [
    'as' => 'visits.store', 'uses' => 'VisitsController@store'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('vists/{ers_location}/create', [
    'as' => 'visits.create', 'uses' => 'VisitsController@create'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('vists/{client}/locations', [
    'as' => 'visits.locations', 'uses' => 'VisitsController@locations'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::get('vists/clients', [
    'as' => 'visits.clients', 'uses' => 'VisitsController@clients'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Commander']);
Route::bind('visits', function($value, $route) {
    return App\AmdErsVisit::findBySlug($value)->first();
});

Route::get('requests/{request}/response_report', [
    'as' => 'requests.response_report', 'uses' => 'RequestsController@response_report'
]);
Route::match(['get', 'post'], 'reports/clients/{client}/responses', [
    'as' => 'reports.clients.responses', 'uses' => 'ClientReportsController@responses'
]);
Route::match(['get', 'post'], 'reports/clients/{client}/patrols', [
    'as' => 'reports.clients.patrols', 'uses' => 'ClientReportsController@patrols'
]);
Route::match(['get', 'post'], 'reports/clients/{client}/responses/special', [
    'as' => 'reports.clients.responses.special', 'uses' => 'ClientReportsController@responses_special'
]);
Route::match(['get', 'post'], 'reports/clients/{client}/patrols/special', [
    'as' => 'reports.clients.patrols.special', 'uses' => 'ClientReportsController@patrols_special'
]);
