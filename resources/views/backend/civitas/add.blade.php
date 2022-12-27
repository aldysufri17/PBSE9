@extends('backend.layouts.app')
@section('title','Tambah Civitas')
@section('content')
@php
    $name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Ubah Data Civitas {{$name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="/civitas">Daftar Civitas</a></div>
            <div class="breadcrumb-item active">Ubah Civitas</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card my-5">
            <form action="{{route('civitas.store')}}" method="post">
                @csrf
                @if (auth()->user()->section_id == 128)
                <input type="text" hidden value="{{$post_by}}" name="post_by">
                @endif
                <div class="card my-3">
                    <div class="card-body p-3">
                        <div class="mt-5">
                            <div class="justify-content-center">
                                <div class="data-penyewa">
                                    <div class="d-flex justify-content-between total font-weight-bold mt-3">
                                        <h4 class="font-weight-bold">Ubah Data Civitas Akademika Tahun
                                            {{ $year }}</h4>
                                    </div>
                                    <input type="text" name="year" hidden value="{{$year}}">
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
                                            <span class="font-weight-bold">Mahasiswa Masuk</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>S1</span><span class="durasi">
                                                <div class="input-group">
                                                    <input required type="text" id="cost" placeholder="Jumlah Orang"
                                                        class="form-control form-control-user @error('S1in') is-invalid @enderror"
                                                        name="S1in" value="{{$civitas ? $incoming_students[0] : 0}}"
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
                                                        name="S2in" value="{{$civitas ? $incoming_students[1] : 0}}"
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
                                                        name="S3in" value="{{$civitas ? $incoming_students[2] : 0}}"
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
                                            <span class="font-weight-bold">Mahasiswa Lulus</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>S1</span><span class="durasi">
                                                <div class="input-group mt-2">
                                                    <input required type="text" id="cost" placeholder="Jumlah Orang"
                                                        class="form-control form-control-user @error('S1out') is-invalid @enderror"
                                                        name="S1out" value="{{$civitas ? $graduate_students[0] : 0}}"
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
                                                        name="S2out" value="{{$civitas ? $graduate_students[1] : 0}}"
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
                                                        name="S3out" value="{{$civitas ? $graduate_students[2] : 0}}"
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
                                            <span class="font-weight-bold">Karyawan (Lab,Tendik,Dosen,Pendukung)</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>S1</span><span class="durasi">
                                                <div class="input-group mt-2">
                                                    <input required type="text" id="S1emp" placeholder="Jumlah Orang"
                                                        class="form-control form-control-user @error('S1emp') is-invalid @enderror"
                                                        name="S1emp" value="{{$civitas ? $employee[0] : 0}}"
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
                                                        name="S2emp" value="{{$civitas ? $employee[1] : 0}}"
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
                                                        name="S3emp" value="{{$civitas ? $employee[2] : 0}}"
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
                    <div class="card-footer text-right border-0">
                        <a class="btn btn-danger mr-3" href="{{route('civitas.index')}}">Batal</a>
                        <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
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