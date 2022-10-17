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
<form action="{{route('audit.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
        @if ($energi->IsNotEmpty())
        <div class="card my-3">
            <div class="card-footer bg-white text-center">
                <h4 class="fw-bold">Rekap Data Penggunaan Energi Pada Gedung {{auth()->user()->name}}</h4>
            </div>
            <!-- <input type="text" name="ha"> -->
            <div class="card-body p-3">
                @foreach ($energi as $key=>$e)
                <div class="mt-5">
                    @if ($key != 0)
                    <hr style="color: red; border:3px solid blue">
                    @endif
                    <span class="fw-bold"><span class="text-danger">*</span> Input Penggunaan Energi Jenis
                        {{$e->name}}</span>
                    <input type="text" name="energy_id[]" hidden value="{{$e->id}}">
                    <div class="form-group row">
                        {{-- Nilai Energi --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Nilai Penggunaan {{$e->name}}</label>
                            <input required type="number" placeholder="Nilai Penggunaan"
                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                name="usage[]">
                            @error('usage')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- Tanggal Awal Penggunaan --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Tanggal Awal Penggunaan</label>
                            <input required type="date"
                                class="form-control form-control-user @error('start_date') is-invalid @enderror"
                                name="start_date[]">
                            @error('start_date')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- Tanggal Akhir Penggunaan --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Tanggal Akhir Penggunaan</label>
                            <input required type="date"
                                class="form-control form-control-user @error('end_date') is-invalid @enderror"
                                name="end_date[]">
                            @error('end_date')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- Tanggal Penggunaan --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Bukti Penggunaan <span class="text-danger">(Max Size
                                :20 MB, jpeg,png,svg,pdf)</span></label>
                            <input required type="file"
                                class="form-control form-control-user @error('invoice') is-invalid @enderror"
                                name="invoice[]">
                            @error('invoice')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="Tambahan">
                    <hr class="mt-5" style="color: red; border:3px solid blue">
                    <span class="fw-bold"><span class="text-danger">*</span> Peta Instalasi Energi Gedung <span
                            class="text-danger">(Max Size:20 MB,pdf)</span></span>
                    <div class="input-group control-group d-flex justify-content-center">
                        <input type="file" class="form-control" value="dsds" name="blueprint" @error('blueprint')
                            is-invalid @enderror>
                    </div>
                    @error('blueprint')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="tambahan">
                    <hr class="mt-5" style="color: red; border:3px solid blue">
                    <span class="fw-bold"><span class="text-danger">*</span> Berkas Tambahan</span>
                    <div class="input-group hdtuto control-group d-flex justify-content-center">
                        <input type="file" class="form-control" name="file[]" @error('file') is-invalid @enderror>
                        <div class="input-group-btn">
                            <button class="btn btn-success" type="button"><i
                                    class="fldemo glyphicon glyphicon-plus"></i>Tambah</button>
                        </div>
                    </div>
                    @error('file')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="clone"></div>
                </div>
                {{$energi->links()}}
            </div>
            <div class="card-footer text-end border-0">
                <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
            </div>
        </div>
        @endif
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
