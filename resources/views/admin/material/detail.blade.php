@extends('campusnet::layouts/main')

@section('content')

<div class="row">
    <div class="col-lg-2 col-md-3">
        @include('campusnet::admin/course/_sidebar')
    </div>
    <div class="col-lg-8 col-md-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Materi Kelas</h6></div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="{{ $material->type->icon }} me-1" data-bs-toggle="tooltip" title="{{ $material->type->name }}"></i> {{ $material->name }}</h6>
                    <div class="btn-group">
                        <a href="{{ route('admin.course.detail', ['id' => $course->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Kembali ke Kelas"><i class="bi-arrow-left"></i></a>
                        <a href="{{ route('admin.material.edit', ['course_id' => $course->id, 'topic_id' => $topic->id, 'material_id' => $material->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Materi"><i class="bi-pencil"></i></a>
                    </div>
                </div>
                <hr>

                @if($material->type->code == 'text')
                    <div class="ql-snow">{!! html_entity_decode($material->content) !!}</div>
                @elseif($material->type->code == 'youtube-video')
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ $content ? $content->name : '' }}?rel=0" allowfullscreen></iframe>
                    </div>
                @elseif($material->type->code == 'assignment')
                    <p><strong>Nama:</strong><br>{{ $content ? $content->name : '-' }}</p>
                    <p><strong>Deskripsi:</strong><br>{{ $content ? $content->description : '-' }}</p>
                    <p><strong>Tanggal Mulai:</strong><br>{{ $content ? date('d/m/Y H:i', strtotime($content->start_at)) : '-' }}</p>
                    <p><strong>Tanggal Selesai:</strong><br>{{ $content ? date('d/m/Y H:i', strtotime($content->end_at)) : '-' }}</p>
                @endif

            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-3">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Tentang Kelas</h6></div>
            <div class="card-body">
                <p><strong>Nama:</strong><br>{{ $course->name }}</p>
                <p><strong>Kategori:</strong><br>{{ $course->category->name }}</p>
                <p><strong>Deskripsi:</strong><br>{!! nl2br($course->description) !!}</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')

<link rel="stylesheet" type="text/css" href="https://campusdigital.id/assets/plugins/quill/quill.snow.css">

@endsection