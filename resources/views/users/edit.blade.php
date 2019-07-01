@extends('app', ['page_title' => 'Users (Details Officers and Commanders)', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12">
        <legend>Edit User</legend>
        <?php
        $amd_users = App\AmdUser::where('employee_id', $user->id);
        if ($amd_users->count() > 0) {
            $amd_user = $amd_users->first();
        }
        ?>
        @if ($amd_users->count() > 0)
        {!! Form::model($amd_user, ['route' => ['users.store'], 'class' => 'form-group', 'files' => true]) !!}
            @include('users/form', ['submit_text' => 'Update User'])
        {!! Form::close() !!}
        @else
        {!! Form::model(new App\AmdUser, ['route' => ['users.store'], 'class' => 'form-group', 'files' => true]) !!}
            @include('users/form', ['submit_text' => 'Update User'])
        {!! Form::close() !!}
        @endif
    </div>
</div>
@endsection