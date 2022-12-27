@extends('backend.layouts.app')
@section('title','Daftar Civitas Akademik')
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>History Data Civitas {{$name}} Tahun {{$year}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="/civitas">Daftar Civitas</a></div>
            <div class="breadcrumb-item active">History Civitas</div>
        </div>
    </div>
    
    <div class="card my-3">
        <div class="card-body p-3">
            <div class="mt-5">
                <div class="justify-content-center">
                    @foreach ($civitases as $civitas)
                    <div class="data-penyewa">
                        <div class="d-flex justify-content-between total font-weight-bold mt-3">
                            <h4 class="font-weight-bold text-warning">Updated {{ date('d F Y', strtotime($civitas->updated_at))}}
                            </h4>
                        </div>
                        <input type="text" name="year" hidden value="{{$year}}">
                        @php
                        $incoming_students = array_values(json_decode($civitas->incoming_students, true));
                        $graduate_students = array_values(json_decode($civitas->graduate_students, true));
                        $employee = array_values(json_decode($civitas->employee, true));
                        @endphp
                        <input type="text" name="id_civitas" hidden value="{{$civitas->ac_id}}">
                        <div class="masuk">
                            <div class="">
                                <span class="font-weight-bold">Mahasiswa Masuk</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="font-weight-bold">S1</span><span class="durasi">
                                    <div class="input-group">
                                        <span class="input-group-text font-weight-bold">{{$incoming_students[0]}} Orang</span>
                                    </div>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="font-weight-bold">S2</span><span class="durasi">
                                    <div class="input-group mt-2">
                                        <span class="input-group-text font-weight-bold">{{$incoming_students[1]}} Orang</span>
                                    </div>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="font-weight-bold">S3</span><span class="durasi">
                                    <div class="input-group mt-2">
                                        <span class="input-group-text font-weight-bold">{{$incoming_students[2]}} Orang</span>
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
                                <span class="font-weight-bold">S1</span><span class="durasi">
                                    <div class="input-group mt-2">
                                        <span class="input-group-text font-weight-bold">{{$graduate_students[0]}} Orang</span>
                                    </div>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="font-weight-bold">S2</span><span class="durasi">
                                    <div class="input-group mt-2">
                                        <span class="input-group-text font-weight-bold">{{$graduate_students[1]}} Orang</span>
                                    </div>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="font-weight-bold">S3</span><span class="durasi">
                                    <div class="input-group mt-2">
                                        <span class="input-group-text font-weight-bold">{{$graduate_students[2]}} Orang</span>
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
                                <span class="font-weight-bold">S1</span><span class="durasi">
                                    <div class="input-group mt-2">
                                        <span class="input-group-text font-weight-bold">{{$employee[0]}} Orang</span>
                                    </div>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="font-weight-bold">S2</span><span class="durasi">
                                    <div class="input-group mt-2">
                                        <span class="input-group-text font-weight-bold">{{$employee[1]}} Orang</span>
                                    </div>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="font-weight-bold">S3</span><span class="durasi">
                                    <div class="input-group mt-2">
                                        <span class="input-group-text font-weight-bold">{{$employee[2]}} Orang</span>
                                    </div>
                                </span>
                            </div>
                            <hr class="my-3" style="color: red; border:1px solid rgb(0, 0, 0)">
                        </div>
                    </div>
                    <hr class="my-5" style="color: red; border:3px solid orange">
                    @endforeach
                    {{$civitases->links()}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection