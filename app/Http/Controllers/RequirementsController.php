<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Input;
use App\AmdActivity;
use App\AmdOption;
use App\AmdService;
use App\AmdRequirement;

class RequirementsController extends Controller
{
    public function index(AmdService $service, AmdOption $option) {
        $requirements = AmdRequirement::where('option_id', $option->id)->get();
        return view('requirements.index', compact('requirements', 'option', 'service'));
    }
    
    public function create(AmdService $service, AmdOption $option) {
        return view('requirements.create', compact('service', 'option'));
    }
    
    public function store(AmdService $service, AmdOption $option) {
        $input = Input::all();
        if ($input['other_requirement_type'] != 0) {
            $input['vehicle_type_id'] = 0;
        }
        $input['option_id'] = $option->id;
        $error = "";
        $existing_requirements = AmdRequirement::where('option_id', $input['option_id'])->where('vehicle_type_id', $input['vehicle_type_id'])->where('other_requirement_type', $input['other_requirement_type']);
        if ($existing_requirements->count() != 0) {
            $error .= "Requirement already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            $requirement = AmdRequirement::create($input);
            if ($requirement) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                AmdActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Requirement was created.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('services.options.requirements.index', [$service->slug(), $option->slug()])
                        ->with('success', '<span class="font-weight-bold">Successful!</span><br />Requirement has been created.');
            } else {
                return Redirect::route('services.options.requirements.index', [$service->slug(), $option->slug()])
                        ->with('error', '<span class="font-weight-bold">Unknown error!</span><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function destroy(AmdService $service, AmdOption $option, AmdRequirement $requirement) {
        $requirement->delete();
        if (!isset($_SESSION)) session_start();
        $halo_user = $_SESSION['halo_user'];
        AmdActivity::create([
            'employee_id' => $halo_user->id,
            'detail' => 'Requirement was deleted.',
            'source_ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return Redirect::route('services.options.requirements.index', [$service->slug(), $option->slug()])
                ->with('success', '<span class="font-weight-bold">Successful!</span><br />Requirement has been deleted.');
    }
}
