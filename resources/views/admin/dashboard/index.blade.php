@extends('campusnet::layouts/main')

@section('content')

<div class="row">
    @for($i=1; $i<=4; $i++)
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card text-dark bg-light mb-3">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    @endfor
</div>

@endsection