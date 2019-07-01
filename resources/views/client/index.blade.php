@extends('app2', ['page_title' => 'Home'])

@section('content')
<div class="row">
    <div class="col-12" style="margin: 0; padding: 0">
        <div id="slide" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach (App\AmdService::where('active', true)->get() as $service)
                <div class="carousel-item @if ($service->id == 1) active @endif">
                    {{ Html::image('images/slide/slide'.$service->id.'.jpg', 'Slide '.$service->id, ['width' => '100%']) }}
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-4">{{ $service->description }}</h1>
                        <p>{{ $service->offerings }}</p>
                        <a data-toggle="modal" data-target="#modal{{ $service->id }}" class="btn btn-secondary">View Packages</a>
                    </div>
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#slide" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#slide" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

@foreach (App\AmdService::where('active', true)->get() as $service)
<div class="modal fade" id="modal{{ $service->id }}" tabindex="-1" role="dialog" aria-labelledby="modal{{ $service->id }}Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>{{ $service->description }}</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ $service->offerings }}</p>
                <table class="table table-striped table-hover">
                    @foreach (App\AmdOption::where('service_id', $service->id)->get() as $option)
                    <tr>
                        <td width="20%">{{ $option->description }}</td>
                        <td width="40%">{{ $option->offerings }}</td>
                        <td width="20%" class="text-center">=N={{ number_format($option->price, 2) }}</td>
                        <td class="text-right"><a class="btn btn-primary">Make Request</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection