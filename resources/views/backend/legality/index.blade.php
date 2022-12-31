@extends('backend.layouts.app')
@if (auth()->user()->section_id == 128)
@section('title','Daftar Departemen')
@else
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
@section('title','Daftar Legalitas Infrastruktur')
@endif

@php
$year_legalitas = App\Models\infrastructure_legality::where('post_by', $post_by)
->select(DB::raw('YEAR(created_at) year'))
->groupBy('year')
->get();

$now_year = Carbon\Carbon::now()->format('Y');
$cekYear = App\Models\infrastructure_legality::where('post_by', $post_by)->whereYear('created_at', $now_year)->first();
@endphp

@section('content')
<x-page-index title="{{auth()->user()->section_id != 128 ? 'Legalitas Infrastruktur '. $name : 'Departemen'}}"
    buttonLabel="Tambah Pengelola Konservasi" routeCreate="">
    <div class="search">
        <form action="{{route('legalitas.index')}}" method="get">
            <div class="input-group">
                <div class="col">
                    <span class="font-weight-bold">Tahun Penggunaan</span>
                    <select id="select"
                        class="form-control selectpicker form-control-user @error('user') is-invalid @enderror"
                        name="year">
                        <option disabled selected>---Pilih Tahun---</option>
                        @if (is_null($cekYear))
                        <option selected value="{{$now_year}}">{{$now_year}}</option>
                        @endif
                        @foreach ($year_legalitas as $data)
                        <option value="{{$data->year}}" @if(Request::has('year'))
                            {{Request::get('year') == $data->year ? 'selected':''}} @else
                            {{ $year == $data->year ? 'selected':''}} @endif>
                            {{ $data->year }}</option>
                        @endforeach
                    </select>
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="card-footer text-right border-0">
                    <button class="btn btn-primary mr-3">Cari Data</button>
                </div>
            </div>
            <input type="text" id="id" name="post_by" value="{{$post_by}}" hidden>
        </form>
    </div>
    @if ($legality->IsNotEmpty())
    <h4 class="font-weight-bold text-center py-2">Audit Pemakaian Energi Departemen {{$name}} Tahun
        {{Request::has('year') ? Request::get('year') : $year}}</h4>
    <div class="out p-4">
        <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>NIDI</th>
                    <th>SLO</th>
                    <th>IJIN OPERASI</th>
                    <th>TTB</th>
                    <th>SOP PENGOPERASIAN</th>
                    <th>SOP PEMELIHARAAN</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($legality as $key=>$data)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$data->items->item}}</td>
                    <td> <a class="table-action btn btn-primary mr-2"
                            href="{{asset('file/legalitas/nidi/'.$data->NDI)}}" target="_blank"><i
                                class="fas fa-download"></i>
                            Download
                        </a>
                    </td>
                    <td> <a class="table-action btn btn-primary mr-2" href="{{asset('file/legalitas/slo/'.$data->SLO)}}"
                            target="_blank"><i class="fas fa-download"></i>
                            Download
                        </a>
                    </td>
                    <td> <a class="table-action btn btn-primary mr-2"
                            href="{{asset('file/legalitas/ijin_operasi/'.$data->IJIN_OPERASI)}}" target="_blank"><i
                                class="fas fa-download"></i>
                            Download
                        </a>
                    </td>
                    <td> <a class="table-action btn btn-primary mr-2" href="{{asset('file/legalitas/ttb/'.$data->TTB)}}"
                            target="_blank"><i class="fas fa-download"></i>
                            Download
                        </a>
                    </td>
                    <td> <a class="table-action btn btn-primary mr-2"
                            href="{{asset('file/legalitas/sop_operasi/'.$data->SOP_OPERASI)}}" target="_blank"><i
                                class="fas fa-download"></i>
                            Download
                        </a>
                    </td>
                    <td> <a class="table-action btn btn-primary mr-2"
                            href="{{asset('file/legalitas/sop_pemeliharaan/'.$data->SOP_PELIHARA)}}" target="_blank"><i
                                class="fas fa-download"></i>
                            Download
                        </a>
                    </td>
                    <td>
                        <a class="table-action btn btn-primary mr-2"
                            href="{{route('legalitas_edit',[$data->il_id, $data->post_by])}}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                            value="{{$data->il_id}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <form action="{{route('legalitas.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="konservasi">
                    <h4 class="font-weight-bold text-center mt-5">AUDIT LEGALITAS INFRASTRUKTUR DEPARTEMEN
                        {{strtoupper($name)}} TAHUN
                        {{Request::has('year') ? Request::get('year') : $year}}</h4>
                    <p class="text-center" style="color: red">Upload Dokumen Legalitas Infrastruktur format
                        (jpeg,png,jpg,svg,pdf,doc,csv,xlsx,xls,docx) Max Size 20Mb </p>
                    <input type="text" hidden name="post_by" value="{{$post_by}}">
                    <input type="text" hidden name="year"
                        value="{{Request::has('year') ? Request::get('year') : $year}}" id="year">

                    @if ($items->isNotEmpty())
                    @foreach ($items as $key=>$item)
                    <input type="text" hidden name="item_id[{{$key}}]" value="{{$item->ili_id}}">
                    <div class="pb-5">
                        <h5 class="font-weight-bold">{{$key+1}}. {{$item->item}}</h5>
                        <div class="d-flex justify-content-center">
                            <div class="card-body pt-0 row">
                                <div class="mb-2 mb-sm-0 mt-2">
                                    <label><span style="color:red;">&#8226; </span><span class="font-weight-bold">NIDI/
                                            NO
                                            IDENTITAS INSTALASI</span></label>
                                    <input type="file" required
                                        class="form-control form-control-user @error('nidi[{{$key}}]') is-invalid @enderror"
                                        name="nidi[{{$key}}]">
                                    @error('nidi[{{$key}}]')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                    <label><span style="color:red;">&#8226; </span><span class="font-weight-bold">SLO
                                        </span></label>
                                    <input type="file" required
                                        class="form-control form-control-user @error('slo[{{$key}}]') is-invalid @enderror"
                                        name="slo[{{$key}}]" value="">
                                    @error('slo[{{$key}}]')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-2 mb-sm-0 mt-2">
                                    <label><span style="color:red;">&#8226; </span><span class="font-weight-bold">IJIN
                                            OPERASI</span></label>
                                    <input type="file" required
                                        class="form-control form-control-user @error('io[{{$key}}]') is-invalid @enderror"
                                        name="io[{{$key}}]" value="">
                                    @error('io[{{$key}}]em')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-body pt-0 row">
                                <div class="mb-2 mb-sm-0 mt-2">
                                    <label><span style="color:red;">&#8226; </span><span class="font-weight-bold">TENAGA
                                            TEKNIK BERSERTIFIKAT</span></label>
                                    <input type="file" required
                                        class="form-control form-control-user @error('ttb[{{$key}}]') is-invalid @enderror"
                                        name="ttb[{{$key}}]" value="">
                                    @error('ttb[{{$key}}]')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                    <label><span style="color:red;">&#8226; </span><span class="font-weight-bold">SOP
                                            PENGOPERASIAN</span></label>
                                    <input type="file" required
                                        class="form-control form-control-user @error('sopo[{{$key}}]') is-invalid @enderror"
                                        name="sopo[{{$key}}]" value="">
                                    @error('sopo[{{$key}}]')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-2 mb-sm-0 mt-2">
                                    <label><span style="color:red;">&#8226; </span><span class="font-weight-bold">SOP
                                            PEMELIHARAAN</span></label>
                                    <input type="file" required
                                        class="form-control form-control-user @error('sopm[{{$key}}]') is-invalid @enderror"
                                        name="sopm[{{$key}}]" value="">
                                    @error('sopm[{{$key}}]')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="align-items-center bg-light p-3 border-secondary rounded">
                        <span class="">Oops!</span><br>
                        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Item Legalitas</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer text-right border-0">
                <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
            </div>
        </div>
    </form>
    @endif
</x-page-index>
@include('backend.legality.modal')
@endsection

@push('scripts')
<script>
    $(document).on('click', '.delete-btn', function () {
        var sid = $(this).val();
        $('#deleteModal').modal('show')
        $('#delete_id').val(sid)
        // alert(sid)
    });
</script>
@endpush