@extends('backend.layouts.app')
@if (auth()->user()->section_id == 128)
@section('title','Daftar Departemen')
@else
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
@section('title','Daftar Kualitas Daya')
@endif

@php
$year_measurement = App\Models\measurement::where('post_by', $post_by)
->select(DB::raw('YEAR(created_at) year'))
->groupBy('year')
->get();

$now_year = Carbon\Carbon::now()->format('Y');
$cekYear = App\Models\measurement::where('post_by', $post_by)->whereYear('created_at', $now_year)->first();
@endphp

@section('content')
<x-page-index title="{{auth()->user()->section_id != 128 ? 'Kualitas Daya '. $name : 'Departemen'}}"
    buttonLabel="Tambah Data" routeCreate="">
    <div class="search">
        <form action="{{route('measurement.index')}}" method="get">
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
                        @foreach ($year_measurement as $data)
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
    @if ($measurement->IsNotEmpty())
    <div class="out p-4">
        <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Daya Aktif</th>
                    <th>Daya Reaktif</th>
                    <th>Daya Semu</th>
                    <th>Tegangan Satu Fasa</th>
                    <th>Tegangan Tiga Fasa</th>
                    <th>Tegangan Unbalance</th>
                    <th>Arus</th>
                    <th>Frekuensi</th>
                    <th>Harmonisa Arus</th>
                    <th>Harmonisa Tegangan</th>
                    <th>Faktor Tegangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($measurement as $key=>$data)
                @php
                $daya_aktif = array_values(json_decode($data->daya_aktif, true));
                $daya_reaktif = array_values(json_decode($data->daya_reaktif, true));
                $daya_semu = array_values(json_decode($data->daya_semu, true));
                $satu_fasa = array_values(json_decode($data->tegangan_satu_fasa, true));
                $tiga_fasa = array_values(json_decode($data->tegangan_tiga_fasa, true));
                $unbalance = array_values(json_decode($data->tegangan_tidak_seimbang, true));
                $arus = array_values(json_decode($data->arus, true));
                @endphp
                <tr>
                    <td>
                        <b><span style="font-size: 15px">Fasa R : {{$daya_aktif[0]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">Fasa S : {{$daya_aktif[1]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">Fasa T : {{$daya_aktif[2]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">TOTAL : {{$daya_aktif[3]}}</span></b>
                        <hr>
                    </td>
                    <td>
                        <b><span style="font-size: 15px">Fasa R : {{$daya_reaktif[0]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">Fasa S : {{$daya_reaktif[1]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">Fasa T : {{$daya_reaktif[2]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">TOTAL : {{$daya_reaktif[3]}}</span></b>
                        <hr>
                    </td>
                    <td>
                        <b><span style="font-size: 15px">Fasa R : {{$daya_semu[0]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">Fasa S : {{$daya_semu[1]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">Fasa T : {{$daya_semu[2]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px">TOTAL : {{$daya_semu[3]}}</span></b>
                        <hr>
                    </td>
                    <td>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>R-N</span> : {{$satu_fasa[0]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>S-N</span> : {{$satu_fasa[1]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>T-N</span> : {{$satu_fasa[2]}}</span></b>
                        <hr>
                    </td>
                    <td>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>RS</span> : {{$tiga_fasa[0]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>ST</span> : {{$tiga_fasa[1]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>TR</span> : {{$tiga_fasa[2]}}</span></b>
                        <hr>
                    </td>
                    <td>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>RS</span> : {{$unbalance[0]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>ST</span> : {{$unbalance[1]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>TR</span> : {{$unbalance[2]}}</span></b>
                        <hr>
                    </td>
                    <td>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>Fasa R</span> : {{$arus[0]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>Fasa S</span> : {{$arus[1]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold"><span
                                        style="font-size: 20px">V</span>Fasa T</span> : {{$arus[2]}}</span></b>
                        <hr>
                        <b><span style="font-size: 15px"><span class="font-weight-bold">NETRAL : {{$arus[3]}}</span></b>
                        <hr>
                    </td>
                    <td><span class="font-weight-bold">{{$data->frekuensi}}</span></td>
                    <td><span class="font-weight-bold">{{$data->harmonisa_arus}}</span></td>
                    <td><span class="font-weight-bold">{{$data->harmonisa_tegangan}}</span></td>
                    <td><span class="font-weight-bold">{{$data->faktor_daya}}</span></td>
                    <td>
                        <a class="table-action btn btn-primary mr-2"
                            href="{{route('measurement_edit',[$data->m_id, $data->post_by])}}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                            value="{{$data->m_id}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <form action="{{route('measurement.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="konservasi">
                    <h4 class="font-weight-bold text-center mt-5">AUDIT KUALITAS DAYA DEPARTEMEN {{strtoupper($name)}}
                        TAHUN
                        {{Request::has('year') ? Request::get('year') : $year}}</h4>
                    <input type="text" hidden name="post_by" value="{{$post_by}}">
                    <input type="text" hidden name="year"
                        value="{{Request::has('year') ? Request::get('year') : $year}}" id="year">
                    <div class="items">
                        <div class="pb-5">
                            <h5 class="font-weight-bold">1. Daya Aktif</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                R</span></label>
                                        <input type="number" placeholder="Fasa R" required
                                            class="form-control form-control-user @error('R[0]') is-invalid @enderror"
                                            name="R[0]">
                                        @error('R[0]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                S</span></label>
                                        <input type="number" placeholder="Fasa S" required
                                            class="form-control form-control-user @error('S[0]') is-invalid @enderror"
                                            name="S[0]" value="">
                                        @error('S[0]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                T</span></label>
                                        <input type="number" placeholder="Fasa T" required
                                            class="form-control form-control-user @error('T[0]') is-invalid @enderror"
                                            name="T[0]" value="">
                                        @error('T[0]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2 mx-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Total</span></label>
                                        <input type="number" placeholder="Total" required
                                            class="form-control form-control-user @error('DT[0]') is-invalid @enderror"
                                            name="DT[0]" value="">
                                        @error('DT[0]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">2. Daya Reaktif</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                R</span></label>
                                        <input type="number" placeholder="Fasa R" required
                                            class="form-control form-control-user @error('R[1]') is-invalid @enderror"
                                            name="R[1]">
                                        @error('R[1]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                S</span></label>
                                        <input type="number" placeholder="Fasa S" required
                                            class="form-control form-control-user @error('S[1]') is-invalid @enderror"
                                            name="S[1]" value="">
                                        @error('S[1]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                T</span></label>
                                        <input type="number" placeholder="Fasa T" required
                                            class="form-control form-control-user @error('T[1]') is-invalid @enderror"
                                            name="T[1]" value="">
                                        @error('T[1]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2 mx-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Total</span></label>
                                        <input type="number" placeholder="Total" required
                                            class="form-control form-control-user @error('DT[1]') is-invalid @enderror"
                                            name="DT[1]" value="">
                                        @error('DT[1]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">3. Daya Semu</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                R</span></label>
                                        <input type="number" placeholder="Fasa R" required
                                            class="form-control form-control-user @error('R[2]') is-invalid @enderror"
                                            name="R[2]">
                                        @error('R[2]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                S</span></label>
                                        <input type="number" placeholder="Fasa S" required
                                            class="form-control form-control-user @error('S[2]') is-invalid @enderror"
                                            name="S[2]" value="">
                                        @error('S[2]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                T</span></label>
                                        <input type="number" placeholder="Fasa T" required
                                            class="form-control form-control-user @error('T[2]') is-invalid @enderror"
                                            name="T[2]" value="">
                                        @error('T[2]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2 mx-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Total</span></label>
                                        <input type="number" placeholder="Total" required
                                            class="form-control form-control-user @error('DT[2]') is-invalid @enderror"
                                            name="DT[2]" value="">
                                        @error('DT[2]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">4. Tegangan 1 Fasa</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>R-N</span></label>
                                        <input type="number" placeholder="V R-N" required
                                            class="form-control form-control-user @error('VRN') is-invalid @enderror"
                                            name="VRN">
                                        @error('VRN')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>S-N</span></label>
                                        <input type="number" placeholder="V S-N" required
                                            class="form-control form-control-user @error('VSN') is-invalid @enderror"
                                            name="VSN" value="">
                                        @error('VSN')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>T-N</span></span></label>
                                        <input type="number" placeholder="V T-N" required
                                            class="form-control form-control-user @error('VTN') is-invalid @enderror"
                                            name="VTN" value="">
                                        @error('VTN')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">5. Tegangan 3 Fasa</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>RS</span></label>
                                        <input type="number" placeholder="VRS" required
                                            class="form-control form-control-user @error('VRS[0]') is-invalid @enderror"
                                            name="VRS[0]">
                                        @error('VRS[0]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>ST</span></label>
                                        <input type="number" placeholder="VST" required
                                            class="form-control form-control-user @error('VST[0]') is-invalid @enderror"
                                            name="VST[0]" value="">
                                        @error('VST[0]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>TR</span></span></label>
                                        <input type="number" placeholder="VTR" required
                                            class="form-control form-control-user @error('VTR[0]') is-invalid @enderror"
                                            name="VTR[0]" value="">
                                        @error('VTR[0]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">6. Tegangan Tidak Seimbang</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>RS</span></label>
                                        <input type="number" placeholder="VRS" required
                                            class="form-control form-control-user @error('VRS[1]') is-invalid @enderror"
                                            name="VRS[1]">
                                        @error('VRS[1]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>ST</span></label>
                                        <input type="number" placeholder="VST" required
                                            class="form-control form-control-user @error('VST[1]') is-invalid @enderror"
                                            name="VST[1]" value="">
                                        @error('VST[1]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold"><span
                                                    style="font-size: 20px">V</span>TR</span></span></label>
                                        <input type="number" placeholder="VTR" required
                                            class="form-control form-control-user @error('VTR[1]') is-invalid @enderror"
                                            name="VTR[1]" value="">
                                        @error('VTR[1]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">7. Arus</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                R</span></label>
                                        <input type="number" placeholder="Fasa R" required
                                            class="form-control form-control-user @error('R[3]') is-invalid @enderror"
                                            name="R[3]">
                                        @error('R[3]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                S</span></label>
                                        <input type="number" placeholder="Fasa S" required
                                            class="form-control form-control-user @error('S[3]') is-invalid @enderror"
                                            name="S[3]" value="">
                                        @error('S[3]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Fasa
                                                T</span></label>
                                        <input type="number" placeholder="Fasa T" required
                                            class="form-control form-control-user @error('T[3]') is-invalid @enderror"
                                            name="T[3]" value="">
                                        @error('T[3]')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Netral</span></label>
                                        <input type="number" placeholder="Fasa T" required
                                            class="form-control form-control-user @error('n') is-invalid @enderror"
                                            name="n" value="">
                                        @error('n')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">8. Frekuensi</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Value</span></label>
                                        <input type="number" placeholder="Frekuensi" required
                                            class="form-control form-control-user @error('f') is-invalid @enderror"
                                            name="f">
                                        @error('f')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">9. Harmonisa Arus</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Value</span></label>
                                        <input type="number" placeholder="Harmonisa Arus" required
                                            class="form-control form-control-user @error('ha') is-invalid @enderror"
                                            name="ha">
                                        @error('ha')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">10. Harmonisa Tegangan</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Value</span></label>
                                        <input type="number" placeholder="Harmonisa Tegangan" required
                                            class="form-control form-control-user @error('ht') is-invalid @enderror"
                                            name="ht">
                                        @error('ht')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5">
                            <h5 class="font-weight-bold">11. Faktor Daya</h5>
                            <div class="d-flex justify-content-center">
                                <div class="card-body pt-0 row">
                                    <div class="mb-2 mb-sm-0 mt-2">
                                        <label><span style="color:red;">&#8226; </span><span
                                                class="font-weight-bold">Value</span></label>
                                        <input type="number" placeholder="Faktor Daya" required
                                            class="form-control form-control-user @error('fd') is-invalid @enderror"
                                            name="fd">
                                        @error('fd')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right border-0">
                <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
            </div>
        </div>
    </form>
    @endif
</x-page-index>
@include('backend.measurement.modal')
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