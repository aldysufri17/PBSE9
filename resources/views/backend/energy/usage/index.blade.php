@extends('backend.layouts.app')
@section('title','Daftar Penggunaan Energi')
@section('content')
@php
$year_energy = App\Models\energy_usage::where('post_by', $post_by)
->select(DB::raw('YEAR(created_at) year'))
->groupBy('year')
->get();
$month = Carbon\Carbon::now()->format('m');
$year = Carbon\Carbon::now()->format('Y');
$tes = Request::has('month') == 1 ? Request::get('month') : $month;
$myDate = $tes."/12/2020";
$date = Carbon\Carbon::createFromFormat('m/d/Y', $myDate);
$monthName = $date->format('F');
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
<x-page-index title="Penggunaan Energi {{$name}}" buttonLabel="Tambah Penggunaan Energi" routeCreate="">
@if ($building->isNotEmpty())
@if ($usage->isNotEmpty())
<div class="d-sm-flex align-items-center mb-4">
    <!--<a href="#" target="_blank" class="btn btn-sm btn-warning" title="unduh csv">
        <i class="fas fa-file-csv"></i> Export CSV
    </a>-->
    @php
        $year_export = Request::has('year') ? Request::get('year') : Carbon\Carbon::now()->format('Y');
        $month_export = Request::has('month') ? Request::get('month') : Carbon\Carbon::now()->format('m');
        $building_export = Request::has('building') ? Request::get('building') : $building->first()->building_id;
    @endphp
    <a href="{{route('energy.export', [$post_by,$year_export,$month_export,$building_export])}}" target="_blank" class="btn btn-sm btn-warning" title="unduh csv">
        <i class="fas fa-file-csv"></i> Export CSV
    </a>

</div>
@endif
<div class="search">
    <form action="{{route('energy-usage.index')}}" method="get">
        <div class="input-group">
            <div class="col">
                <span class="font-weight-bold">Nama Gedung</span>
                <select id="select"
                    class="form-control selectpicker form-control-user @error('user') is-invalid @enderror"
                    name="building" required>
                    {{-- <option disabled selected>---Pilih Gedung---</option> --}}
                    @foreach ($building as $data)
                    <option value="{{$data->building_id}}" 
                        @if(Request::has('building')) {{Request::get('building') == $data->building_id ? 'selected':''}} 
                        @endif>
                        {{ $data->name }}</option>
                    @endforeach
                </select>
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col">
                <span class="font-weight-bold">Tahun Penggunaan</span>
                <select id="select"
                    class="form-control selectpicker form-control-user @error('user') is-invalid @enderror"
                    name="year" required>
                    <option disabled selected>---Pilih Tahun---</option>
                    @if ($year_energy->isEmpty())
                    <option selected>{{$year}}</option>
                    @endif
                    @foreach ($year_energy as $data)
                    <option value="{{$data->year}}"
                        @if(Request::has('year')) 
                        {{Request::get('year') == $data->year ? 'selected':''}} 
                        @else
                        {{ $year == $data->year ? 'selected':''}}
                        @endif>
                        {{ $data->year }}</option>
                    @endforeach
                </select>
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col">
                <span class="font-weight-bold">Bulan Penggunaan</span>
                <select id="room" required class="form-control selectroom room" name="month">
                    <option disabled selected>---Pilih Bulan---</option>
                    <option value="1" @if (Request::has('month')) {{Request::get('month') == 1 ? 'selected':''}}
                        @else {{$month == 1 ? 'selected':''}} @endif {{$month >= 1 ? '' : 'disabled'}}>
                        Januari</option>
                    <option value="2" @if (Request::has('month')) {{Request::get('month') == 2 ? 'selected':''}}
                        @else {{$month == 2 ? 'selected':''}} @endif {{$month >= 2 ? '' : 'disabled'}}>
                        Februari</option>
                    <option value="3" @if (Request::has('month')) {{Request::get('month') == 3 ? 'selected':''}}
                        @else {{$month == 3 ? 'selected':''}} @endif {{$month >= 3 ? '' : 'disabled'}}>
                        Maret</option>
                    <option value="4" @if (Request::has('month')) {{Request::get('month') == 4 ? 'selected':''}}
                        @else {{$month == 4 ? 'selected':''}} @endif {{$month >= 4 ? '' : 'disabled'}}>
                        April</option>
                    <option value="5" @if (Request::has('month')) {{Request::get('month') == 5 ? 'selected':''}}
                        @else {{$month == 5 ? 'selected':''}} @endif {{$month >= 5 ? '' : 'disabled'}}>
                        Mei</option>
                    <option value="6" @if (Request::has('month')) {{Request::get('month') == 6 ? 'selected':''}}
                        @else {{$month == 6 ? 'selected':''}} @endif {{$month >= 6 ? '' : 'disabled'}}>
                        Juni</option>
                    <option value="7" @if (Request::has('month')) {{Request::get('month') == 7 ? 'selected':''}}
                        @else {{$month == 7 ? 'selected':''}} @endif {{$month >= 7 ? '' : 'disabled'}}>
                        Juli</option>
                    <option value="8" @if (Request::has('month')) {{Request::get('month') == 8 ? 'selected':''}}
                        @else {{$month == 8 ? 'selected':''}} @endif {{$month >= 8 ? '' : 'disabled'}}>
                        Agustus</option>
                    <option value="9" @if (Request::has('month')) {{Request::get('month') == 9 ? 'selected':''}}
                        @else {{$month == 9 ? 'selected':''}} @endif {{$month >= 9 ? '' : 'disabled'}}>
                        September</option>
                    <option value="10" @if (Request::has('month')) {{Request::get('month') == 10 ? 'selected':''}}
                        @else {{$month == 10 ? 'selected':''}} @endif {{$month >= 10 ? '' : 'disabled'}}>Oktober
                    </option>
                    <option value="11" @if (Request::has('month')) {{Request::get('month') == 11 ? 'selected':''}}
                        @else {{$month == 11 ? 'selected':''}} @endif {{$month >= 11 ? '' : 'disabled'}}>November
                    </option>
                    <option value="12" @if (Request::has('month')) {{Request::get('month') == 12 ? 'selected':''}}
                        @else {{$month == 12 ? 'selected':''}} @endif {{$month >= 12 ? '' : 'disabled'}}>Desember
                    </option>
                </select>
            </div>
            <div class="card-footer text-right border-0">
                <button class="btn btn-primary mr-3">Cari Data</button>
            </div>
        </div>
        <input type="text" id="id" name="post_by" value="{{$post_by}}" hidden>
    </form>
</div>

<div class="out p-4">
    @if ($usage->IsNotEmpty())
    <h4 class="font-weight-bold text-center py-2">Audit Pemakaian Energi Tahun
        {{Request::has('year') ? Request::get('year') : $year}}
        Bulan {{$monthName}}</h4>
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Enegi</th>
                <th>Nilai</th>
                <th>Biaya</th>
                <th>Tgl Awal</th>
                <th>Tgl Akhir</th>
                <th>Bukti Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usage as $key=>$data)
            <tr>
                @php
                $energi = App\Models\Energy::where('energy_id',$data->energy_id)->value('name');
                $unit = App\Models\Energy::where('energy_id',$data->energy_id)->value('unit');
                @endphp
                <td>{{$key+1}}</td>
                <td>{{$energi}}</td>
                <td>{{$data->usage}} {{$unit}}</td>
                <td>Rp. {{ number_format($data->cost, 2, ',', '.') }}</td>
                <td>{{$data->start_date}}</td>
                <td>{{$data->end_date}}</td>
                <td>
                    <a class="table-action btn btn-primary mr-2" href="{{asset('file/invoice/'.$data->invoice)}}"
                        target="_blank"><i class="fas fa-eye"></i>
                        Lihat Bukti
                    </a>
                </td>
                <td>
                    <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                        value="{{$data->eu_id}}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <a class="table-action btn btn-primary mr-2" href="{{route('energy-usage.edit',[$data->eu_id, $post_by])}}" title="Edit">
                        <i class="fas fa-pen"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <form action="{{route('energy-usage.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" hidden name="building_id"  value="{{Request::has('building') ? Request::get('building') : $building->first()->building_id}}">
        <input type="text" hidden name="year"  value="{{Request::has('year') ? Request::get('year') : $year}}" id="year">
        <input type="text" hidden name="month"  value="{{Request::has('month') ? Request::get('month') : $month}}" id="month">
        <input type="text" hidden name="post_by" value="{{$post_by}}" id="post_by">
        <div class="card">
            <div class="card-body">
                <div class="pemakaian">
                    <h4 class="font-weight-bold text-center py-2">Audit Pemakaian Energi Tahun {{Request::has('year') ? Request::get('year') : $year}}
                        Bulan {{$monthName}}</h4>
                    @foreach ($energy as $key=>$e)
                    <div class="card mt-4">
                        <h6 class="font-weight-bold"><span>{{$key+1}}.</span> Input Penggunaan Energi Jenis
                            {{$e->name}}</h6>
                        <input type="text" name="energy_id[]" hidden value="{{$e->energy_id}}">
                        <div class="form-group row">
                            {{-- Nilai Energi --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Nilai Penggunaan</label>
                                <div class="input-group">
                                    <input required type="number" placeholder="Nilai Penggunaan"
                                        class="form-control form-control-user @error('usage') is-invalid @enderror"
                                        name="usage[]" value="{{ old('usage.'. $key) }}">
                                    <span class="input-group-text">{{$e->unit}}</span>
                                </div>
                                @error('usage')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Nilai Energi --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Biaya Penggunaan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input required type="text" id="cost" placeholder="Biaya Penggunaan"
                                        class="form-control form-control-user @error('cost') is-invalid @enderror"
                                        name="cost[]" value="{{ old('cost.'. $key) }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                                @error('cost')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Tanggal Awal Penggunaan --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Tanggal Awal Penggunaan</label>
                                <input required type="date"
                                    class="form-control form-control-user @error('start_date') is-invalid @enderror"
                                    name="start_date[]" value="{{ old('start_date.'. $key) }}">
                                @error('start_date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Tanggal Akhir Penggunaan --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Tanggal Akhir Penggunaan</label>
                                <input required type="date"
                                    class="form-control form-control-user @error('end_date') is-invalid @enderror"
                                    name="end_date[]" value="{{ old('end_date.'. $key) }}">
                                @error('end_date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Tanggal Penggunaan --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Bukti Penggunaan <span class="text-danger">(Max
                                    Size
                                    :20 MB, jpeg,png,svg,pdf)</span></label>
                                <input required type="file"
                                    class="form-control form-control-user @error('invoice') is-invalid @enderror"
                                    name="invoice[]" value="{{ old('invoice.'. $key) }}">
                                @error('invoice')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer text-right border-0">
                    <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>
@else
<div class="align-items-center bg-light p-3 border-secondary rounded">
    <span class="">Oops!</span><br>
    <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Gedung</p>
</div>
@endif
</x-page-index>
@include('backend.energy.usage.modal')
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