@extends('backend.layouts.app')
@section('title','Edit Section')
@section('content')
<x-page-form page='edit' route="section.index" title="Section">
    <form action="{{route('section.update',$section->section_id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body p-3">
            <h3 class="fw-bold text-center">Detail Data Section {{$section->name}}</h3>
            <label><span style="color:red;">*</span><span class="font-weight-bold">Nama Section</span></label>
            <input required type="text" placeholder="Nama Section"
                class="form-control form-control-user @error('section') is-invalid @enderror" value="{{$section->name}}"
                name="name">
            @error('section')
            <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="mt-2">
                <label><span style="color:red;">*</span><span class="font-weight-bold">Daftar
                        Departemen</span></label>
                @php
                $user_select = App\Models\user::where('section_id', $section->section_id)->get();
                @endphp
                @if ($user_select->isEmpty())
                <div class="d-flex justify-content-between total font-weight-bold mb-2">
                    <select id="role" class="form-control form-control-user @error('role') is-invalid @enderror"
                        name="user[]">
                        <option disabled selected>---Pilih Departemen---</option>
                        @foreach ($users as $data)
                        <option value="{{$data->user_id}}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success btn-add" type="button">Tambah</button>
                </div>
                @else
                @foreach ($user_select as $key=>$item)
                <div class="d-flex justify-content-between total font-weight-bold mb-2">
                    <select id="role" class="form-control form-control-user @error('user') is-invalid @enderror"
                        name="user[]">
                        <option disabled selected>---Pilih Departemen---</option>
                        @foreach ($user as $data)
                        <option {{$data->user_id == $item->user_id ? "selected" : ""}} value="{{$data->user_id}}">
                            {{ $data->name }}</option>
                        @endforeach
                    </select>
                    @if ($key > 0)
                    <button class="btn btn-danger delete-btn" type="button" value="{{$item->room_id}}">Hapus</button>
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
            <a class="btn btn-danger mr-3" href="{{ route('section.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#rmv").hide();
        $(".btn-add").click(function () {
            $(".clone").append(`
                <div class="hide mt-3">
                    <div class="input-group hdtuto control-group d-flex justify-content-center">
                        <select id="role" class="form-control form-control-user @error('role') is-invalid @enderror"
                    name="user[]">
                        <option disabled selected>---Pilih Departemen---</option>
                        @foreach ($users as $data)
                        <option value="{{$data->user_id}}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                            <div class="input-group-btn">
                            <button class="btn btn-danger" id="rmv" type="button"><i
                                    class="fldemo glyphicon glyphicon-remove"></i> Hapus</button>
                            </div>
                    </div>
                    @error('user')
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