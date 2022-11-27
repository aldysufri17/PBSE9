@extends('frontend.layouts.app')
@section('title', 'Tambah Data Gedung')
@section('content')
<x-alert />
<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold">Tambah Data Gedung</h2>
            <ol>
                <li><a href="/">Beranda</a></li>
                <li>Tambah Data Gedung</li>
            </ol>
        </div>
    </div>
</section>
<!-- Breadcrumbs Section -->

<div class="container-fluid">
    <div class="card my-5">
        <form action="{{route('building.store')}}" method="post">
            @csrf
            <div class="card-body p-3">
            <h3 class="fw-bold text-center">Tambah Data Gedung</h3>
                <label></label><span style="color:red;">*</span>Nama Gedung</label>
                <input required type="text" placeholder="Nama Gedung"
                    class="form-control form-control-user @error('building') is-invalid @enderror" name="building">
                @error('building')
                <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="mt-2">
                    <label></label><span style="color:red;">*</span>Daftar Ruangan</label>
                    <div class="d-flex justify-content-between total font-weight-bold">
                        <input required type="text" placeholder="Nama Ruangan"
                            class="form-control form-control-user @error('room') is-invalid @enderror"
                            name="room[]" value="">
                        @error('room')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <button class="btn btn-success btn-add" type="button">Tambah</button>
                        {{-- <a href="{{route('input.civitas')}}"><span class="badge bg-primary">Ubah</span></a> --}}
                    </div>
                    <div class="clone"></div>
                </div>
            </div>
            <div class="card-footer text-end border-0">
                <a class="btn btn-danger mr-3" href="{{ route('master.audit') }}">Batal</a>
                <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#rmv").hide();
        $(".btn-add").click(function () {
            $(".clone").append(`
                <div class="hide mt-3">
                    <div class="input-group hdtuto control-group d-flex justify-content-center">
                        <input required type="text" placeholder="Nama Ruangan"
                            class="form-control form-control-user @error('room') is-invalid @enderror"
                            name="room[]" value="">
                            <div class="input-group-btn">
                            <button class="btn btn-danger" id="rmv" type="button"><i
                                    class="fldemo glyphicon glyphicon-remove"></i> Hapus</button>
                            </div>
                    </div>
                    @error('room')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            `)
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".hdtuto").remove();
        });
    });
</script>
@endpush