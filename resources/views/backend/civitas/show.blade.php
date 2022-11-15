@extends('backend.layouts.app')
@section('title','Data Civitas Tahunan')
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Data Civitas</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="/energi-usage">Daftar Civitas Tahunan</a></div>
            <div class="breadcrumb-item active"><a href="javascript:history.back()">Daftar Civitas tahun {{$year}}</a></div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header pb-0">
                <h4>Data Civitas Tahun {{$year}}</h4>
            </div>
            @php
            $incoming_students = array_values(json_decode($civitas->incoming_students, true));
            $graduate_students = array_values(json_decode($civitas->graduate_students, true));
            $employee = array_values(json_decode($civitas->employee, true));
            @endphp
            <div class="card-body p-2">
                <div class="justify-content-center p-3">
                    <div class="data-penyewa">
                        <div class="masuk">
                            <div class="">
                                <span class="font-weight-bold">Mahasiswa Masuk</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S1</span><span class="durasi">{{$civitas ? $incoming_students[0] : 0}} Orang</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S2</span><span class="durasi">{{$civitas ? $incoming_students[1] : 0}} Orang</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S3</span><span class="durasi">{{$civitas ? $incoming_students[2] : 0}} Orang</span>
                            </div>
                            <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                            <div class="d-flex justify-content-between font-weight-bold">
                                <span>Total</span><span class="durasi">{{$civitas ? array_sum($incoming_students) : 0}} Orang</span>
                            </div>
                        </div>
                        <div class="masuk mt-3">
                            <div class="">
                                <span class="font-weight-bold">Mahasiswa Lulus</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S1</span><span class="durasi">{{$civitas ? $graduate_students[0] : 0}} Orang</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S2</span><span class="durasi">{{$civitas ? $graduate_students[1] : 0}} Orang</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S3</span><span class="durasi">{{$civitas ? $graduate_students[2] : 0}} Orang</span>
                            </div>
                            <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                            <div class="d-flex justify-content-between font-weight-bold">
                                <span>Total</span><span class="durasi">{{$civitas ? array_sum($graduate_students) : 0}} Orang</span>
                            </div>
                        </div>
                        <div class="masuk mt-3">
                            <div class="">
                                <span class="font-weight-bold">Karyawan (Lab,Tendik,Dosen,Pendukung)</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S1</span><span class="durasi">{{$civitas ? $employee[0] : 0}} Orang</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S2</span><span class="durasi">{{$civitas ? $employee[1] : 0}} Orang</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>S3</span><span class="durasi">{{$civitas ? $employee[2] : 0}} Orang</span>
                            </div>
                            <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                            <div class="d-flex justify-content-between font-weight-bold">
                                <span>Total</span><span class="durasi">{{$civitas ? array_sum($employee) : 0}} Orang</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('backend.infrastruktur.modal')
@endsection

@push('scripts')
<script>

$(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true
        });

        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
            // alert(sid)
        });
    });

</script>
@endpush
