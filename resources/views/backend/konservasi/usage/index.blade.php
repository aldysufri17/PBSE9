@extends('backend.layouts.app')
@if (auth()->user()->section_id == 128)
@section('title','Daftar Departemen')
@else
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
@section('title','Daftar Pengelola Konservasi')
@endif

@php
$konservasiValidate = App\Models\conservation_management::where('post_by', $post_by)
->whereYear('created_at', '=', $year)
->first();
if ($konservasiValidate) {
$konservasi_item = App\Models\conservation_item::where('category', 1)->get();
} else {
$konservasi_item = App\Models\conservation_item::all();
}

$year_konservasi = App\Models\conservation_management::where('post_by', $post_by)
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

@section('content')
<x-page-index title="{{auth()->user()->section_id != 128 ? 'Pengelola Konservasi '. $name : 'Departemen'}}"
    buttonLabel="Tambah Pengelola Konservasi" routeCreate="">
    <div class="search">
        <form action="{{route('konservasi_usage.index')}}" method="get">
            <div class="input-group">
                <div class="col">
                    <span class="font-weight-bold">Tahun Penggunaan</span>
                    <select id="select"
                        class="form-control selectpicker form-control-user @error('user') is-invalid @enderror"
                        name="year" required>
                        <option disabled selected>---Pilih Tahun---</option>
                        @if ($year_konservasi->isEmpty())
                        <option selected>{{$year}}</option>
                        @endif
                        @foreach ($year_konservasi as $data)
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
    @if ($konservasi->IsNotEmpty())
    <div class="out p-4">
        <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Konservasi</th>
                    <th>Ada/Tidak</th>
                    <th>Keterangan</th>
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($konservasi as $key=>$data)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$data->conservation_item->name}}</td>
                    <td>{{$data->item}}</td>
                    <td>{{$data->desc}}</td>
                    <td>
                        @if (!is_null($data->file))
                        <a class="table-action btn btn-primary mr-2" href="{{asset('file/convertion/'.$data->file)}}"
                            target="_blank"><i class="fas fa-eye"></i>
                            Lihat Berkas
                        </a>
                        @endif
                    </td>
                    <td>
                        <a class="table-action btn btn-primary mr-2"
                            href="{{route('konservasi_usage.edit',[$data->cm_id,$post_by])}}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <form action="{{route('konservasi.input')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="konservasi">
                    <h4 class="font-weight-bold text-center">AUDIT PENGELOLAAN KONSERVASI ENERGI DAN AIR</h4>
                    <input type="text" hidden name="post_by" value="{{$post_by}}">
                    <input type="text" hidden name="year"
                        value="{{Request::has('year') ? Request::get('year') : $year}}" id="year">
                    <input type="text" hidden name="month" value="{{Request::has('month') ? Request::get('month') : $month}}"
                        id="month">
                    @foreach ($konservasi_item as $key=>$item)
                    <input type="text" hidden name="category[]" value="{{$item->category}}">
                    <input type="text" hidden name="coi_id[]" value="{{$item->coi_id}}">
                    <div class="pb-2">
                        <div class="card-header pb-0 bg-white font-weight-bold">
                            <h6>{{$key+1}}. {{$item->name}}</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-sm-0">
                                <label><span style="color:red;">&#8226; </span><span
                                        class="font-weight-bold">Ada/Tidak</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="item[{{$key}}]" id="radio"
                                        value="ada">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Ada
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" checked type="radio" name="item[{{$key}}]"
                                        id="radio" value="tidak">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Tidak Ada
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3 mt-3 mb-sm-0">
                                <label><span style="color:red;">&#8226; </span><span
                                        class="font-weight-bold">Keterangan</span></label>
                                <textarea class="form-control @error('deskripsi') @enderror"
                                    placeholder="Keterangan Pengelolaan Konservasi" name="desc[{{$key}}]" rows="5"
                                    style="height:10%;"></textarea>
                            </div>
                            <div class="mb-3 mt-3 mb-sm-0">
                                <label><span style="color:red;">&#8226; </span><span class="font-weight-bold">Berkas
                                        Tambahan</span><span class="text-danger">(Max Size:20 MB,
                                        jpeg,png,svg,pdf)</span></label>
                                <input type="file"
                                    class="form-control form-control-user @error('file') is-invalid @enderror"
                                    name="file[]" value="">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer text-right border-0">
                <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
            </div>
        </div>
    </form>
    @endif
</x-page-index>
{{-- @include('backend.infrastruktur.modal') --}}
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