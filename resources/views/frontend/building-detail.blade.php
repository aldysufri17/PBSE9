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
        <form action="{{route('building.update',$building->building_id)}}" method="post">
            @csrf
            <div class="card-body p-3">
            <h3 class="fw-bold text-center">Detail Data Gedung {{$building->name}}</h3>
                <label></label><span style="color:red;">*</span>Nama Gedung</label>
                <input required type="text" placeholder="Nama Gedung"
                    class="form-control form-control-user @error('building') is-invalid @enderror" value="{{$building->name}}" name="building">
                @error('building')
                <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="mt-2">
                    <label></label><span style="color:red;">*</span>Daftar Ruangan</label>
                    @foreach ($room as $key=>$item)
                    <div class="d-flex justify-content-between total font-weight-bold mb-2">
                        <input required type="text" placeholder="Nama Ruangan"
                            class="form-control form-control-user @error('room_in') is-invalid @enderror"
                            name="room_in[{{$item->room_id}}]" value="{{$item->name}}">
                        @error('room_in')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        @if ($key > 0)
                        <button class="btn btn-danger delete-btn" type="button" value="{{$item->room_id}}">Hapus</button>
                        @else
                        <button class="btn btn-success btn-add" type="button">Tambah</button>
                        @endif
                    </div>
                    @endforeach
                    <div class="clone"></div>
                </div>
            </div>
            <div class="card-footer text-end border-0">
                <a class="btn btn-danger mr-3" href="{{ route('master.audit') }}">Batal</a>
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
                <div class="hide mt-3">
                    <div class="input-group hdtuto control-group d-flex justify-content-center">
                        <input required type="text" placeholder="Nama Ruangan"
                            class="form-control form-control-user @error('room') is-invalid @enderror"
                            name="room[]" value="">
                            <div class="input-group-btn">
                            <button class="btn btn-danger" id="rmv" type="button"><i
                                    class="fldemo glyphicon glyphicon-remove"></i> Hapus</button>
                            </div>
                    </div>
                    @error('room')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            `)
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".hdtuto").remove();
        });

        $(document).on('click', '.delete-btn', function () {
            id = $(this).val()
            $.ajax({
                url: "/room/delete",
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