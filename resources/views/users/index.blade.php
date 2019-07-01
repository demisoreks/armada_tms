@extends('app', ['page_title' => 'Users (Details Officers and Commanders)', 'open_menu' => 'admin'])

@section('content')
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <strong>Active</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="15%"><strong>USERNAME</strong></th>
                                    <th width="15%"><strong>CODE NAME</strong></th>
                                    <th width="10%"><strong>PICTURE</strong></th>
                                    <th width="12%"><strong>MOBILE NO.</strong></th>
                                    <th><strong>EMAIL ADDRESS</strong></th>
                                    <th width="10%"><strong>REGION</strong></th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <?php
                                    $amd_user = App\AmdUser::where('employee_id', $user->id);
                                    ?>
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>@if ($amd_user->count() > 0) {{ $amd_user->first()->name }} @endif</td>
                                    <td class="text-center">@if (File::exists('storage/pictures/'.$amd_user->first()->id.'.jpg')) {{ Html::image('storage/pictures/'.$amd_user->first()->id.'.jpg', 'User picture', ['height' => '100px', 'class' => 'rounded-circle']) }} @endif</td>
                                    <td>@if ($amd_user->count() > 0) {{ $amd_user->first()->mobile_no }} @endif</td>
                                    <td>@if ($amd_user->count() > 0) {{ $amd_user->first()->email }} @endif</td>
                                    <td>@if ($amd_user->count() > 0) {{ $amd_user->first()->region->name }} @endif</td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('users.edit', [$user->slug()]) }}"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection