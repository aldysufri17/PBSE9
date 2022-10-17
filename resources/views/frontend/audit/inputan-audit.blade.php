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
<form action="{{route('audit.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
        @if ($usage)
        <div class="card my-3">
            <div class="card-footer bg-white text-center">
                <h3 class="fw-bold">Audit Departemen {{auth()->user()->name}} Bulan
                    {{ \Carbon\Carbon::now()->format('F') }} Sudah dilakukan..</h3>
            </div>
        </div>
        @else
        <div class="card my-3">
            <div class="penggunaan">
                <div class="card-footer bg-white text-center">
                    <h3 class="fw-bold">Penggunaan Energi dan Air Departemen {{auth()->user()->name}}</h3>
                </div>
                <div class="card-body p-3">
                    <div class="infrastruktur mb-5">
                        <h5 class="fw-bold">A. Jumlah Infrastruktur Energi</h5>
                        <div class="pb-4">
                            <span class="fw-bold">1. AC Ruangan</span>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>AC Konvensional</h6>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>AC Inverter</label>
                                        <div class="row">
                                            <div class="col">
                                                <input required type="number" placeholder="Nilai Penggunaan"
                                                    class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                    name="usage[]">
                                            </div>
                                        </div>
                                </div>
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>AC Manual</h6>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>AC Otomatis</h6>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-4">
                            <span class="fw-bold">2. Lampu</span>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>Lampu Konvensional</h6>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>LED</h6>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-4">
                            <span class="fw-bold">3. Kipas</span>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>Konvensional</label>
                                        <div class="row">
                                            <div class="col">
                                                <input required type="number" placeholder="Nilai Penggunaan"
                                                    class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                    name="usage[]">
                                            </div>
                                        </div>
                                </div>
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>Otomatis</h6>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-4">
                            <span class="fw-bold">4. Operasi Genset</span>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>Konvensional</h6>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">
                                    <h6 class="fw-bold"><span style="color:red;">*</span>Otomatis</h6>
                                    <div class="row">
                                        <div class="col">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3" style="color: red; border:3px solid blue">
                    <div class="pemakaian">
                        <h5 class="fw-bold">B. Pemakaian Energi Dan Air</h5>
                        <div class="pb-5">
                            @foreach ($energi as $key=>$e)
                            <div class="items mt-4">
                                <span class="fw-bold"><span>{{$key+1}}.</span> Input Penggunaan Energi Jenis
                                    {{$e->name}}</span>
                                <input type="text" name="energy_id[]" hidden value="{{$e->id}}">
                                <div class="form-group row">
                                    {{-- Nilai Energi --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>Nilai Penggunaan</label>
                                        <div class="input-group">
                                            <input required type="number" placeholder="Nilai Penggunaan"
                                                class="form-control form-control-user @error('usage') is-invalid @enderror"
                                                name="usage[]">
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
                                                name="cost[]"
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
                                            name="start_date[]">
                                        @error('start_date')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    {{-- Tanggal Akhir Penggunaan --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>Tanggal Akhir Penggunaan</label>
                                        <input required type="date"
                                            class="form-control form-control-user @error('end_date') is-invalid @enderror"
                                            name="end_date[]">
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
                                            name="invoice[]">
                                        @error('invoice')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{$energi->links()}}
                    </div>
                </div>
            </div>
            <hr class="my-3" style="color: red; border:3px solid blue">
            <div class="intensitas">
                <div class="card-footer bg-white text-center">
                    <h3 class="fw-bold">Intensitas Konsumsi Energi dan Air Bulan
                        {{ \Carbon\Carbon::now()->format('F') }}</h3>
                </div>
                <div class="card-body p-3 pt-0">
                    <div class="my-5">
                        <span class="fw-bold"><span class="text-danger">*</span>Intensitas Konsumsi Energi per bulan
                            (KWH/m2/bulan)</span>
                        <div class="form-group">
                            {{-- Nilai Energi --}}
                            <div class="my-2">
                                <label>Nilai IKE</label>
                                <div class="input-group">
                                    <input required type="number" placeholder="Nilai Penggunaan"
                                        class="form-control form-control-user @error('usage') is-invalid @enderror"
                                        name="usage[]">
                                </div>
                                @error('usage')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-deskripsi mb-3">
                                <label>Keterangan</label>
                                <textarea class="form-control" placeholder="Keterangan Konsumsi Energi" name="deskripsi"
                                    rows="10" style="height:80%;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <span class="fw-bold"><span class="text-danger">*</span>Intensitas Konsumsi Energi per bulan
                            (KWH/m2/bulan)</span>
                        <div class="form-group">
                            {{-- Nilai Energi --}}
                            <div class="my-2">
                                <label>Nilai IKE</label>
                                <div class="input-group">
                                    <input required type="number" placeholder="Nilai Penggunaan"
                                        class="form-control form-control-user @error('usage') is-invalid @enderror"
                                        name="usage[]">
                                </div>
                                @error('usage')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-deskripsi mb-3">
                                <label>Keterangan</label>
                                <textarea class="form-control" placeholder="Keterangan Konsumsi Energi" name="deskripsi"
                                    rows="10" style="height:80%;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <span class="fw-bold"><span class="text-danger">*</span>Intensitas Konsumsi Energi per bulan
                            (KWH/m2/bulan)</span>
                        <div class="form-group">
                            {{-- Nilai Energi --}}
                            <div class="my-2">
                                <label>Nilai IKE</label>
                                <div class="input-group">
                                    <input required type="number" placeholder="Nilai Penggunaan"
                                        class="form-control form-control-user @error('usage') is-invalid @enderror"
                                        name="usage[]">
                                </div>
                                @error('usage')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-deskripsi mb-3">
                                <label>Keterangan</label>
                                <textarea class="form-control" placeholder="Keterangan Konsumsi Energi" name="deskripsi"
                                    rows="10" style="height:80%;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <span class="fw-bold"><span class="text-danger">*</span>Intensitas Konsumsi Energi per bulan
                            (KWH/m2/bulan)</span>
                        <div class="form-group">
                            {{-- Nilai Energi --}}
                            <div class="my-2">
                                <label>Nilai IKE</label>
                                <div class="input-group">
                                    <input required type="number" placeholder="Nilai Penggunaan"
                                        class="form-control form-control-user @error('usage') is-invalid @enderror"
                                        name="usage[]">
                                </div>
                                @error('usage')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-deskripsi mb-3">
                                <label>Keterangan</label>
                                <textarea class="form-control" placeholder="Keterangan Konsumsi Energi" name="deskripsi"
                                    rows="10" style="height:80%;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end border-0">
                <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
            </div>
        </div>
        @endif
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {
        $("#cost").keyup(function (e) {
            $(this).val(format($(this).val()));
        });
    });

    var format = function (num) {
        var str = num.toString().replace("", ""),
            parts = false,
            output = [],
            i = 1,
            formatted = null;
        if (str.indexOf(".") > 0) {
            parts = str.split(".");
            str = parts[0];
        }
        str = str.split("").reverse();
        for (var j = 0, len = str.length; j < len; j++) {
            if (str[j] != ",") {
                output.push(str[j]);
                if (i % 3 == 0 && j < (len - 1)) {
                    output.push(",");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };

</script>
@endpush
