@extends('campusnet::layouts/main')

@section('content')

<div class="card">
    <div class="card-header h5">Data Kelas</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->category->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $("#datatable").DataTable();
</script>

@endsection

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

@endsection