@extends('backend.layouts.app')
@if (auth()->user()->section_id == 128)
@section('title',"Detail Bagian")
@else
@section('title',"Detail Gedung")
@endif
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{auth()->user()->section_id == 128 ? 'Detail Bagian' : 'Detail Gedung '.$building->name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
            @if (auth()->user()->section_id == 128)
            <div class="breadcrumb-item active"><a href="javascript:history.back()">Daftar Bagian</a></div>
            @else
            <div class="breadcrumb-item active"><a href="{{route('building.index')}}">Daftar Gedung</a></div>
            @endif
            <div class="breadcrumb-item active">
                {{auth()->user()->section_id == 128 ? 'Detail Bagian' : 'Detail Gedung '.$building->name}}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            @if (auth()->user()->section_id != 128)
        <div class="p-4">
            <form action="{{route('building.update',$building->building_id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body p-3">
                    <input type="text" name="building_id" value="{{$building->building_id}}" hidden>
                    <h3 class="fw-bold text-center">Detail Data Gedung {{$building->name}}</h3>
                    <label><span style="color:red;">*</span><span class="font-weight-bold">Nama Gedung</span></label>
                    <input required type="text" placeholder="Nama Gedung"
                        class="form-control form-control-user @error('building') is-invalid @enderror"
                        value="{{$building->name}}" name="building_name">
                    @error('building')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="mt-2">
                        <label><span style="color:red;">*</span><span class="font-weight-bold">Daftar
                                Ruangan</span></label>
                        @foreach ($room as $key=>$item)
                        <div class="d-flex justify-content-between total font-weight-bold mb-2">
                            <input required type="text" placeholder="Nama Ruangan"
                                class="form-control form-control-user @error('room_in') is-invalid @enderror"
                                name="room_in[{{$item->room_id}}]" value="{{$item->name}}">
                            @error('room_in')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            @if ($key > 0)
                            <button class="btn btn-danger delete-btn" type="button"
                                value="{{$item->room_id}}">Hapus</button>
                            @else
                            <button class="btn btn-success btn-add" type="button">Tambah</button>
                            @endif
                        </div>
                        @endforeach
                        <div class="clone"></div>
                    </div>
                </div>
                <div class="card-footer text-end border-0">
                    <a class="btn btn-danger mr-3" href="{{ route('building.index') }}">Batal</a>
                    <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                </div>
            </form>
        </div>
        @else
        <div class="py-4">
            @if ($building->IsNotEmpty())
            <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Gedung</th>
                        <th>Nama Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($building as $key => $data)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->user->name}}</td>

                        <td>
                            <a href="{{route('building.show_admin', $data->building_id)}}" class="table-action btn btn-primary
                                mr-2" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                            <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip"
                                title="Delete" value="{{$data->building_id}}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="align-items-center bg-light p-3 border-secondary rounded">
                <span class="">Oops!</span><br>
                <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Gedung</p>
            </div>
            @endif
        </div>
        @endif
        </div>
    </div>
</section>
@include('backend.building.modal')
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