@extends('frontend.layouts.app')
@section('title', 'Input data Audit')
@section('content')
<x-alert />
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold">Input data Audit</h2>
            <ol>
                <li><a href="/">Beranda</a></li>
                <li>Input data Audit</li>
            </ol>
        </div>

    </div>
</section>
<section>
    <div class="container-fluid">
        @if ($posts->IsNotEmpty())
        <div class="card my-3">
            <div class="card-footer bg-white text-center">
                <h4 class="fw-bold">Riwayat Audit Gedung {{auth()->user()->name}}</h4>
            </div>
            <div class="card-body p-3">
                <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal Input</th>
                            <th>Jenis Energi</th>
                            <th>Nilai Penggunaan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <tr>
                            <td class="text-center">{{$post->created_at->format('d M Y')}}
                                <strong class="text-muted">({{$post->created_at->format('H:i:s A')}})</strong></td>
                            <td>{{$post->energy->name}}</td>
                            <td>{{$post->usage}} {{$post->energy->unit}}</td>
                            <td>{{$post->start_date}}</td>
                            <td>{{$post->end_date}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="text-center">
            <h5 class="text-danger">Oops Belum terdapat data audit.</h5>
        </div>
        @endif
</section>
@endsection

@push('scripts')
<script>
    $('#dataTable').DataTable({
        responsive: true
    });

</script>
@endpush
