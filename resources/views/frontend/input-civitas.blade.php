@extends('frontend.layouts.app')
@section('title', 'Input data Civitas')
@section('content')
<x-alert />
<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold">Input data Civitas</h2>
            <ol>
                <li><a href="/">Beranda</a></li>
                <li>Input data Civitas</li>
            </ol>
        </div>

    </div>
</section><!-- Breadcrumbs Section -->
<div class="container-fluid">
    <form action="{{route('civitas.store')}}" method="post">
        @csrf
        <div class="card my-3">
            <div class="card-body p-3">
                <div class="mt-5">
                    <div class="justify-content-center">
                        <div class="data-penyewa">
                            <div class="d-flex justify-content-between total font-weight-bold mt-3">
                                <h4 class="fw-bold">Ubah Data Civitas Akademika Departemen Tahun
                                    {{ \Carbon\Carbon::now()->format('Y') }}</h4>
                            </div>
                            @if ($civitas)
                            @php
                            $incoming_students = array_values(json_decode($civitas->incoming_students, true));
                            $graduate_students = array_values(json_decode($civitas->graduate_students, true));
                            $employee = array_values(json_decode($civitas->employee, true));
                            @endphp
                            <input type="text" name="id_civitas" hidden value="{{$civitas->ac_id}}">
                            @endif
                            <div class="masuk">
                                <div class="">
                                    <span class="fw-bold">Mahasiswa Masuk</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">
                                        <div class="input-group">
                                            <input required type="text" id="cost" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S1in') is-invalid @enderror"
                                                name="S1in" value="{{$civitas ? $incoming_students[0] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S1in')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">
                                        <div class="input-group mt-2">
                                            <input required type="text" id="cost" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S2in') is-invalid @enderror"
                                                name="S2in" value="{{$civitas ? $incoming_students[1] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S2in')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">
                                        <div class="input-group mt-2">
                                            <input required type="text" id="cost" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S3in') is-invalid @enderror"
                                                name="S3in" value="{{$civitas ? $incoming_students[2] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S3in')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                            </div>
                            <div class="masuk mt-3">
                                <div class="">
                                    <span class="fw-bold">Mahasiswa Lulus</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">
                                        <div class="input-group mt-2">
                                            <input required type="text" id="cost" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S1out') is-invalid @enderror"
                                                name="S1out" value="{{$civitas ? $graduate_students[0] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S1out')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">
                                        <div class="input-group mt-2">
                                            <input required type="text" id="S2out" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S2out') is-invalid @enderror"
                                                name="S2out" value="{{$civitas ? $graduate_students[1] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S2out')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">
                                        <div class="input-group mt-2">
                                            <input required type="text" id="S3out" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S3out') is-invalid @enderror"
                                                name="S3out" value="{{$civitas ? $graduate_students[2] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S3out')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                            </div>
                            <div class="masuk mt-3">
                                <div class="">
                                    <span class="fw-bold">Karyawan (Lab,Tendik,Dosen,Pendukung)</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">
                                        <div class="input-group mt-2">
                                            <input required type="text" id="S1emp" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S1emp') is-invalid @enderror"
                                                name="S1emp" value="{{$civitas ? $employee[0] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S1emp')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">
                                        <div class="input-group mt-2">
                                            <input required type="text" id="cost" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S2emp') is-invalid @enderror"
                                                name="S2emp" value="{{$civitas ? $employee[1] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S2emp')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">
                                        <div class="input-group mt-2">
                                            <input required type="text" id="cost" placeholder="Jumlah Orang"
                                                class="form-control form-control-user @error('S3emp') is-invalid @enderror"
                                                name="S3emp" value="{{$civitas ? $employee[2] : ''}}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            <span class="input-group-text">Orang</span>
                                            @error('S3emp')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </span>
                                </div>
                                <hr class="my-3" style="color: red; border:1px solid rgb(0, 0, 0)">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer text-end border-0">
                <a class="btn btn-danger mr-3" href="{{route('rekap.audit')}}">Batal</a>
                <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
            </div>
        </div>
    </form>
</div>
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
