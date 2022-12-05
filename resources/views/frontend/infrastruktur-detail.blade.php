@extends('frontend.layouts.app')
@section('title', 'Detail Data Gedung')
@section('content')
<x-alert />
<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold">Detail Data Gedung</h2>
            <ol>
                <li><a href="/">Beranda</a></li>
                <li>Detail Data Gedung</li>
            </ol>
        </div>
    </div>
</section>
<!-- Breadcrumbs Section -->

<div class="container-fluid">
    <div class="card my-5">
        <form action="{{route('infrastruktur.input')}}" method="post">
        @csrf
        <div class="card-body p-4">
            <h3 class="fw-bold text-center">Data Gedung {{$building->name}} Ruang {{$room->name}}
            </h3>
            <input type="text" value="{{$building->building_id}}" name="building" hidden>
            <input type="text" value="{{$room->room_id}}" name="room" hidden>
            <div class="mt-2">
                @if ($infrastruktur->IsEmpty())
                <div class="infrastruktur d-flex justify-content-between total font-weight-bold">
                    <div class="col">
                        <span class="fw-bold">Nama Infrastruktur</span>
                        <input required type="text" placeholder="Nama Infrastruktur"
                            class="form-control form-control-user @error('inf') is-invalid @enderror" name="inf[]"
                            value="">
                        @error('inf')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col mx-2">
                        <span class="fw-bold">Kapasitas (Watt)</span>
                        <input required type="number" placeholder="Kapasitas"
                            class="form-control form-control-user @error('cty') is-invalid @enderror" name="cty[]"
                            value="">
                        @error('cty')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col">
                        <span class="fw-bold">Kuantitas</span>
                        <input required type="number" placeholder="Kuantitas"
                            class="form-control form-control-user @error('qty') is-invalid @enderror" name="qty[]"
                            value="">
                        @error('qty')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <button class="btn btn-success btn-add" type="button">Tambah</button>
                </div>
                @else
                @foreach ($infrastruktur as $key=>$item)
                <div class="infrastruktur d-flex justify-content-between total font-weight-bold">
                    <div class="col">
                        <span class="fw-bold">Nama Infrastruktur</span>
                        <input required type="text" placeholder="Nama Infrastruktur"
                            class="form-control form-control-user @error('inf') is-invalid @enderror"
                            value="{{$item->name}}" name="inf[]" value="">
                        @error('inf')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col mx-2">
                        <span class="fw-bold">Kapasitas (Watt)</span>
                        <input required type="number" placeholder="Kapasitas"
                            class="form-control form-control-user @error('cty') is-invalid @enderror"
                            value="{{$item->capacity}}" name="cty[]">
                        @error('cty')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col">
                        <span class="fw-bold">Kuantitas</span>
                        <input required type="number" placeholder="Kuantitas"
                            class="form-control form-control-user @error('qty') is-invalid @enderror" name="qty[]"
                            value="{{$item->quantity}}">
                        @error('qty')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    @if ($key > 0)
                    <button class="btn btn-danger delete-btn" value="{{$item->iq_id}}">Hapus</button>
                    @else
                    <button class="btn btn-success btn-add" type="button">Tambah</button>
                    @endif
                </div>
                @endforeach
                @endif
                <div class="clone"></div>
            </div>
        </div>
        <div class="card-footer text-end border-0">
            <a class="btn btn-danger mr-3" href="{{ route('audit.input') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
        </form>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#rmv").hide();
        $(".btn-add").click(function () {
            $(".clone").append(`
            <div class="infrastruktur hdtuto mt-2 d-flex justify-content-between total font-weight-bold">
                                        <div class="col">
                                            <span class="fw-bold">Nama Infrastruktur</span>
                                            <input required type="text" placeholder="Nama Infrastruktur"
                                                class="form-control form-control-user @error('inf') is-invalid @enderror"
                                                name="inf[]" value="">
                                            @error('inf')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col mx-2">
                                            <span class="fw-bold">Kapasitas</span>
                                            <input required type="number" placeholder="Kapasitas"
                                                class="form-control form-control-user @error('cty') is-invalid @enderror"
                                                name="cty[]" value="">
                                            @error('cty')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <span class="fw-bold">Kuantitas</span>
                                            <input required type="number" placeholder="Kuantitas"
                                                class="form-control form-control-user @error('qty') is-invalid @enderror"
                                                name="qty[]" value="">
                                            @error('qty')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <button class="btn btn-danger remove-infrastruktur" id="rmv" type="button"><i
                                    class="fldemo glyphicon glyphicon-remove"></i> Hapus</button>
                                    </div>
            `)
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".hdtuto").remove();
        });

        $(document).on('click', '.delete-btn', function () {
            id = $(this).val()
            $.ajax({
                url: "/infras/delete",
                type: "GET",
                data: {
                    id: id,
                },
                success: function (data) {
                    if (data.status == 200) {
                        window.location.reload();
                    }
                },
            });
        });
    });
</script>
@endpush