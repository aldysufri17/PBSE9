@extends('frontend.layouts.app')
@section('title', 'Input data Audit')
@section('content')
<x-alert />
<!-- ======= Breadcrumbs Section ======= -->
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
</section><!-- Breadcrumbs Section -->
<form action="{{route('tahunan.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
        <div class="card my-3">
            <div class="card-footer bg-white text-center">
                <h4 class="fw-bold">Rekap Data Penggunaan Energi Pada Gedung {{auth()->user()->name}}</h4>
            </div>
            <!-- <input type="text" name="ha"> -->
            <div class="card-body p-3">
                <div class="mt-5">
                    <div class="justify-content-center">
                        <div class="data-penyewa">
                            <div class="d-flex justify-content-between total font-weight-bold mt-3">
                                <h4 class="fw-bold">Data Civitas Akademika Departemen Tahun {{ \Carbon\Carbon::now()->format('Y') }}</h4>
                                <a href="/profile"><span class="badge bg-primary">Ubah</span></a>
                            </div>
                            <div class="masuk">
                                <div class="">
                                    <span class="fw-bold">Mahasiswa Masuk</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">100 Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">100 Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">100 Orang</span>
                                </div>
                                <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span><span class="durasi">100 Orang</span>
                                </div>
                            </div>
                            <div class="masuk mt-3">
                                <div class="">
                                    <span class="fw-bold">Mahasiswa Lulus</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">100 Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">100 Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">100 Orang</span>
                                </div>
                                <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span><span class="durasi">100 Orang</span>
                                </div>
                            </div>
                            <div class="masuk mt-3">
                                <div class="">
                                    <span class="fw-bold">Karyawan (Lab,Tendik,Dosen,Pendukung)</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">100 Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">100 Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">100 Orang</span>
                                </div>
                                <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span><span class="durasi">100 Orang</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="color: red; border:3px solid blue">
                </div>
            </div>
            <div class="card-footer text-end border-0">
                <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#rmv").hide();
        $(".btn-success").click(function () {
            $(".clone").append(`
                <div class="hide mt-3">
                    <div class="input-group hdtuto control-group d-flex justify-content-center">
                        <input type="file" class="form-control" required name="file[]" @error('file') is-invalid @enderror>
                            <div class="input-group-btn">
                            <button class="btn btn-danger" id="rmv" type="button"><i
                                    class="fldemo glyphicon glyphicon-remove"></i> Hapus</button>
                            </div>
                    </div>
                    @error('file')
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