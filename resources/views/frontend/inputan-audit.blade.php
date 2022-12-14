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
<div class="container-fluid">
    @if ($cekInfrastruktur && $cekPemakaian && $cekKonservasi)
    <div class="card my-3">
        <div class="card-footer bg-white text-center">
            <h3 class="fw-bold">Audit Departemen {{auth()->user()->name}} Bulan
                {{ \Carbon\Carbon::now()->format('F') }} Sudah dilakukan..</h3>
        </div>
    </div>
    @else
    <div class="audit my-3">
        <div class="card-footer bg-white text-center">
            <h3 class="fw-bold">AUDIT DEPARTEMEN {{strtoupper(auth()->user()->name)}}</h3>
        </div>
        <div class="card-body p-3">
            @if ($building->IsNotEmpty())
            <form action="{{route('updateInfrastruktur.input')}}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="infrastruktur mb-5">
                            <h4 class="fw-bold text-center py-2">AUDIT JUMLAH INFRASTRUKTUR</h4>
                            <div class="pb-4">
                                <span class="fw-bold"></span>
                                <div class="form-group row">
                                    <div class="building">
                                        <span class="fw-bold">Nama Gedung</span>
                                        <select id="select" required class="form-select selectpicker form-control-user"
                                            name="building">
                                            <option disabled selected>---Pilih Gedung---</option>
                                            @foreach ($building as $data)
                                            <option value="{{$data->building_id}}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="room my-2">
                                        <span class="fw-bold">Nama Ruangan</span>
                                        <select id="room" required class="form-select selectroom room" name="room">
                                        </select>
                                    </div>
                                    <div class="text-end mt-3 btn-area">
                                        <button class="btn btn-primary btn-edit-inf"></button>
                                    </div>
                                    <div class="infrastruktur-parent">
                                    </div>
                                    <div class="clone-infrastruktur"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
            @if (!$cekInfrastruktur && $infrastruktur->IsNotEmpty())
            <form action="{{route('infrastruktur.input')}}" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="infrastruktur mb-5">
                            <h4 class="fw-bold text-center py-2">AUDIT JUMLAH INFRASTRUKTUR</h4>
                            @foreach ($infrastruktur as $key=>$item)
                            <div class="pb-4">
                                <span class="fw-bold">{{$key+1}}. {{$item->name}}</span>
                                <div class="form-group row">
                                    @php
                                    $types = App\Models\infrastructure::where('name',$item->name)->get();
                                    @endphp
                                    @foreach ($types as $data)
                                    <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                        <h6 class="fw-bold"><span style="color:red;">*</span>{{$data->type}}
                                        </h6>
                                        <div class="row">
                                            <div class="col">
                                                <input required type="number" placeholder="Quantity"
                                                    class="form-control form-control-user @error('qty') is-invalid @enderror"
                                                    name="qty[{{$data->is_id}}]"
                                                    value="{{ old('qty.'. $data->is_id) }}">
                                                @error('qty')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <input required type="number" placeholder="Capacity"
                                                    class="form-control form-control-user @error('cty') is-invalid @enderror"
                                                    name="cty[{{$data->is_id}}]"
                                                    value="{{ old('cty.'. $data->is_id) }}">
                                                @error('cty')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer text-end border-0">
                        <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                    </div>
                </div>
            </form>
            <hr class="my-5" style="color: red; border:3px solid blue">
            @endif

            @if (!$cekPemakaian && $energy->IsNotEmpty())
            <form action="{{route('pemakaian.input')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="pemakaian">
                            <h4 class="fw-bold text-center py-2">AUDIT PEMAKAIAN ENERGI DAN AIR</h4>
                            <div class="pb-5">
                                @foreach ($energy as $key=>$e)
                                <div class="items mt-4">
                                    <span class="fw-bold"><span>{{$key+1}}.</span> Input Penggunaan Energi Jenis
                                        {{$e->name}}</span>
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
                                            <span style="color:red;">*</span>Bukti Penggunaan <span
                                                class="text-danger">(Max
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
                        </div>
                    </div>
                    <div class="card-footer text-end border-0">
                        <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                    </div>
                </div>
            </form>
            <hr class="my-5" style="color: red; border:3px solid blue">
            @endif

            @if (!$cekKonservasi && $konservasi->IsNotEmpty())
            <form action="{{route('konservasi.input')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="konservasi">
                            <h4 class="fw-bold text-center py-2">AUDIT PENGELOLAAN KONSERVASI ENERGI DAN AIR</h4>
                            @foreach ($konservasi as $key=>$item)
                            <input type="text" name="category[{{$item->coi_id}}]" hidden value="{{$item->category}}">
                            <div class="pb-2">
                                <div class="card-header bg-white fw-bold">{{$key+1}}. {{$item->name}}</div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answer[{{$item->coi_id}}]"
                                            id="radio" value="ada">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Ada
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" checked type="radio"
                                            name="answer[{{$item->coi_id}}]" id="radio" value="tidak">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Tidak Ada
                                        </label>
                                    </div>
                                    <textarea class="form-control @error('deskripsi') @enderror"
                                        placeholder="Keterangan Pengelolaan Konservasi"
                                        name="desc_kon[{{$item->coi_id}}]" rows="5" style="height:10%;"></textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer text-end border-0">
                        <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(".btn-area").hide();
    $(document).ready(function () {
        $(document).on('change', '.selectpicker', function () {
            var select = $('#select option:selected').val()
            $.ajax({
                url: "{{ route('room.ajax') }}",
                type: "GET",
                data: {
                    select: select
                },
                success: function (data) {
                    if (data) {
                        $('#room').empty()
                        $("#room").append(
                            '<option disabled selected>---Pilih Ruangan---</option>');
                        $.each(data, function (key, room) {
                            $('select[name="room"]').append('<option value="' + room
                                .room_id + '">' + room.name + '</option>');
                        })
                    } else {
                        $('#room').empty()
                    }
                }
            });
        });

        $(document).on('change', '.selectroom', function () {
            var select = $('#room option:selected').val()
            $.ajax({
                url: "{{ route('roomInfrastruktur.ajax') }}",
                type: "GET",
                data: {
                    select: select
                },
                success: function (data) {
                    if (data.cekNull == '0') {
                        $(".btn-edit-inf").html('Tambah Infrastruktur');
                    } else {
                        $(".btn-edit-inf").html('Edit Infrastruktur');
                    }
                    $(".btn-area").show();
                    $('.infrastruktur-parent').html(data.output)
                }
            });
        });
    });
</script>
@endpush