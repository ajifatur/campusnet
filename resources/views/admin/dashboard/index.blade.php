@extends('campusnet::layouts/admin/main')

@section('title', 'Dashboard')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Dashboard</h1>
</div>
<div class="row">
    <div class="col-md-6 col-xl-8 mb-3 mb-md-0">
		<div class="alert alert-success" role="alert">
			<div class="alert-message">
				<h4 class="alert-heading">Selamat Datang!</h4>
				<p class="mb-0">Selamat datang kembali <strong>{{ Auth::user()->name }}</strong> di CampusNet.</p>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="alert alert-warning" role="alert">
			<div class="alert-message">
				<figure>
					<blockquote class="blockquote">
						<p>{{ $quote['text'] }}</p>
					</blockquote>
					<figcaption class="blockquote-footer">
						{{ $quote['author'] }}
					</figcaption>
				</figure>
			</div>
		</div>
	</div>
</div>

@endsection