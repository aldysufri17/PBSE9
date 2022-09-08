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
<form action="{{route('audit.store')}}" method="post">
    @csrf
    <div class="container-fluid">
        <div class="card mt-3">
            <div class="card-footer bg-white text-center">
                <b>Masukkan Data Penggunaan Energi</b>
            </div>
            <!-- <input type="text" name="ha"> -->
            <div class="card-body">
                <div class="my-3">
                    @foreach ($energi as $e)
                    <div class="input-group hdtuto control-group d-flex justify-content-center">
                        <div class="col-md-3">
                            <input type="text" placeholder="" name="nama_energi[{{$e->nama}}]" class="myfrm form-control @error('nama_energi[{{$e->nama}}]') is-invalid @enderror" value="{{$e->nama}}">
                            @error('nama_energi[{{$e->nama}}]')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="number" placeholder="Nilai Penggunaan" name="nilai_energi[{{$e->nama}}]"
                                class="myfrm form-control @error('nilai_energi') is-invalid @enderror" value="{{ old('nilai_energi[]') }}">
                            @error('nilai_energi')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="date" placeholder="Waktu Penggunaan" name="date[{{$e->nama}}]" class="myfrm form-control @error('date') is-invalid @enderror">
                            @error('date')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="file" placeholder="Gambar Bukti" name="BuktiPembayaran[{{$e->nama}}]" class="myfrm form-control @error('date') is-invalid @enderror">
                            @error('date')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    @endforeach
                    <!-- <div class="clone"></div> -->
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
                    <div class="input-group hdtuto control-group lst increment">
                        <select class="form-control form-control-user @error('user_id') is-invalid @enderror" name="energi_id[]">
                            <option selected disabled>Pilih Jenis Energi</option>
                            @foreach ($energi as $data)
                            <option value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                        </select>
                        <div class="col-md-3">
                            <input type="number" placeholder="Nilai Penggunaan" name="nilai_energi[]" class="myfrm form-control">
                        </div>
                        <div class="col-md-3">
                            <input type="date" placeholder="Waktu Penggunaan" name="date[]" class="myfrm form-control">
                        </div>
                        <div class="input-group-btn">
                            <button class="btn btn-danger" id="rmv" type="button"><i
                                    class="fldemo glyphicon glyphicon-remove"></i> Hapus Form</button>
                        </div>
                    </div>
                </div>
            `)
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".hdtuto").remove();
        });
    });

</script>
@endpush
