<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Input;
use DB;
use App\AccEmployee;
use App\AccRole;
use App\AccEmployeeRole;
use App\AmdUser;

class UsersController extends Controller
{
    public function index() {
        $detailer_role_id = AccRole::where('privileged_link_id', DB::table('amd_config')->whereId(1)->first()->link_id)->where('title', 'Detailer')->first()->id;
        $commander_role_id = AccRole::where('privileged_link_id', DB::table('amd_config')->whereId(1)->first()->link_id)->where('title', 'Commander')->first()->id;
        $users_per_role = AccEmployeeRole::whereRaw('role_id IN ('.$detailer_role_id.', '.$commander_role_id.')')->pluck('employee_id')->toArray();
        $users = AccEmployee::where('active', true)->whereRaw('id in ('.implode(',', $users_per_role).')')->get();
        return view('users.index', compact('users'));
    }
    
    public function edit(AccEmployee $user) {
        return view('users.edit', compact('user'));
    }
    
    public function store() {
        $input = Input::all();
        $error = "";
        if (Input::hasFile('picture')) {
            if (!in_array(Input::file('picture')->getClientOriginalExtension(), ['jpg'])) {
                $error .= "Invalid file type. Only jpg is allowed.<br />";
            }
            if (Input::file('picture')->getSize() > 1048576) {
                $error .= "File too large. File must be less than 1MB.<br />";
            }
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<span class="font-weight-bold">Oops!</span><br />'.$error)
                    ->withInput();
        } else {
            unset($input['picture']);
            $employee = AccEmployee::where('username', $input['username'])->first();
            $users = AmdUser::where('employee_id', $employee->id);
            unset($input['username']);
            if ($users->count() == 0) {
                $input['employee_id'] = $employee->id;
                $user = AmdUser::create($input);
                if (!$user) {
                    return Redirect::route('users.index')
                            ->with('error', '<span class="font-weight-bold">Cannot create user!</span><br />Please contact administrator.');
                }
            } else {
                $user = $users->first();
                if (!$user->update($input)) {
                    return Redirect::route('users.index')
                            ->with('error', '<span class="font-weight-bold">Cannot update user!</span><br />Please contact administrator.');
                }
            }
            if (Input::hasFile('picture')) {
                Input::file('picture')->storeAs('public/pictures', $user->id.'.jpg');
            }
            return Redirect::route('users.index')
                    ->with('success', '<span class="font-weight-bold">Successful!</span><br />User has been updated.');
        }
    }
}
