@extends('campusnet::layouts/site/main')

@section('content')

<div class="row py-5">
    <section class="section-course">
        <div class="container">
            <h4>Kategori</h4>
            @if(count($categories) > 0)
                <div class="row"> 
                    @foreach($categories as $category)
                    <a href="{{ route('site.category.detail', ['slug' => $category->slug]) }}" class="col-4 col-md-3 col-lg-2 text-center mb-2 mb-lg-0 transition">
                        <div class="card h-100">
                            <div class="card-body p-2"><i class="bi-box h5"></i><br>{{ $category->name }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <hr>
                <div class="d-flex justify-content-center">
                    {!! $categories->links() !!}
                </div>
            @else
                <p><em>Belum ada data.</em></p>
            @endif
        </div>
    </section>
</div>

@endsection