@extends('backend.layouts.app')
@section('title','Ubah Legalitas')
@section('content')
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Ubah Data Legalitas {{$name}} Tahun {{$year}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="/legalitas">Daftar Legalitas</a></div>
            <div class="breadcrumb-item active">Ubah Legalitas</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card my-5">
            <form action="{{route('legalitas.update', $legality->il_id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="ili_id" value="{{$legality->ili_id}}" hidden>
                <input type="text" name="year" value="{{$year}}" hidden>
                <input type="text" name="post_by" value="{{$legality->post_by}}" hidden>
                <div class="card">
                    <div class="card-body">
                        <div class="konservasi">
                            <h4 class="font-weight-bold text-center mt-5">EDIT LEGALITAS {{$legality->items->item}}
                                TAHUN {{$year}}</h4>
                            <p class="text-center" style="color: red">Upload Dokumen Legalitas Infrastruktur format
                                (jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx) Max Size 20Mb </p>
                            <div class="pb-5">
                                <h5 class="font-weight-bold"></h5>
                                <div class="d-flex justify-content-center">
                                    <div class="card-body pt-0 row">
                                        <div class="mb-2 mb-sm-0 mt-2">
                                            <label><span style="color:red;">&#8226; </span><span
                                                    class="font-weight-bold">NIDI/
                                                    NO
                                                    IDENTITAS INSTALASI</span></label>
                                            <div class="mb-2">
                                                <a class="table-action btn btn-primary mr-2"
                                                    href="{{asset('file/legalitas/nidi/'.$legality->NDI)}}"
                                                    target="_blank"><i class="fas fa-download"></i>
                                                    Download
                                                </a>
                                            </div>
                                            <input type="file"
                                                class="form-control form-control-user @error('nidi') is-invalid @enderror"
                                                name="nidi">
                                            @error('nidi')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                            <label><span style="color:red;">&#8226; </span><span
                                                    class="font-weight-bold">SLO
                                                </span></label>
                                            <div class="mb-2">
                                                <a class="table-action btn btn-primary mr-2"
                                                    href="{{asset('file/legalitas/slo/'.$legality->SLO)}}"
                                                    target="_blank"><i class="fas fa-download"></i>
                                                    Download
                                                </a>
                                            </div>
                                            <input type="file"
                                                class="form-control form-control-user @error('slo') is-invalid @enderror"
                                                name="slo" value="">
                                            @error('slo')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-2 mb-sm-0 mt-2">
                                            <label><span style="color:red;">&#8226; </span><span
                                                    class="font-weight-bold">IJIN
                                                    OPERASI</span></label>
                                            <div class="mb-2">
                                                <a class="table-action btn btn-primary mr-2"
                                                    href="{{asset('file/legalitas/ijin_operasi/'.$legality->IJIN_OPERASI)}}"
                                                    target="_blank"><i class="fas fa-download"></i>
                                                    Download
                                                </a>
                                            </div>
                                            <input type="file"
                                                class="form-control form-control-user @error('io') is-invalid @enderror"
                                                name="io" value="">
                                            @error('ioem')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="card-body pt-0 row">
                                        <div class="mb-2 mb-sm-0 mt-2">
                                            <label><span style="color:red;">&#8226; </span><span
                                                    class="font-weight-bold">TENAGA
                                                    TEKNIK BERSERTIFIKAT</span></label>
                                            <div class="mb-2">
                                                <a class="table-action btn btn-primary mr-2"
                                                    href="{{asset('file/legalitas/ttb/'.$legality->TTB)}}"
                                                    target="_blank"><i class="fas fa-download"></i>
                                                    Download
                                                </a>
                                            </div>
                                            <input type="file"
                                                class="form-control form-control-user @error('ttb') is-invalid @enderror"
                                                name="ttb" value="">
                                            @error('ttb')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                            <label><span style="color:red;">&#8226; </span><span
                                                    class="font-weight-bold">SOP
                                                    PENGOPERASIAN</span></label>
                                            <div class="mb-2">
                                                <a class="table-action btn btn-primary mr-2"
                                                    href="{{asset('file/legalitas/sop_operasi/'.$legality->SOP_OPERASI)}}"
                                                    target="_blank"><i class="fas fa-download"></i>
                                                    Download
                                                </a>
                                            </div>
                                            <input type="file"
                                                class="form-control form-control-user @error('sopo') is-invalid @enderror"
                                                name="sopo" value="">
                                            @error('sopo')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-2 mb-sm-0 mt-2">
                                            <label><span style="color:red;">&#8226; </span><span
                                                    class="font-weight-bold">SOP
                                                    PEMELIHARAAN</span></label>
                                            <div class="mb-2">
                                                <a class="table-action btn btn-primary mr-2"
                                                    href="{{asset('file/legalitas/sop_pemeliharaan/'.$legality->SOP_PELIHARA)}}"
                                                    target="_blank"><i class="fas fa-download"></i>
                                                    Download
                                                </a>
                                            </div>
                                            <input type="file"
                                                class="form-control form-control-user @error('sopm') is-invalid @enderror"
                                                name="sopm" value="">
                                            @error('sopm')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right border-0">
                        <a class="btn btn-danger mr-3" href="{{ route('legalitas.index') }}">Batal</a>
                        <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection