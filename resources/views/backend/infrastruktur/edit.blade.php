@extends('backend.layouts.app')
@section('title','Edit Infrastruktur')
@section('content')
<x-page-form page='edit' route="infrastruktur.index" title="Infrastruktur">
    <form action="{{route('infrastruktur.update', $infrastruktur->name)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group my-2">
            <input type="text" name="Iname" hidden value="{{$infrastruktur->name}}">
            <div class=" mt-2">
                <span style="color:red;">*</span>Nama</label>
                <input autocomplete="off" type="text" name="name" id="name"
                    class="form-control form-control-user @error('name') is-invalid @enderror"
                    value="{{$infrastruktur->name}}" placeholder="Name">
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            @php
            $types = App\Models\infrastructure::where('name',$infrastruktur->name)->get();
            @endphp

            @foreach ($types as $key=>$item)
            <div class="tambahan mt-2 hdtuto">
                <span class="fw-bold"><span class="text-danger">*</span> Tipe Infrastruktur {{$key+1}}</span>
                <div class="input-group control-group d-flex justify-content-center">
                    <input type="text" class="form-control @error('type') is-invalid @enderror" placeholder="Tipe"
                        name="type[]" value="{{$item->type}}">
                    <button class="btn btn-danger" id="rmv" type="button">Hapus</button>
                </div>
                @error('type')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            @endforeach

            <div class="tambahan mt-2">
                <span class="fw-bold"><span class="text-danger">*</span> Tipe Infrastruktur Baru</span>
                <div class="input-group hdtuto control-group d-flex justify-content-center">
                    <input type="text" class="form-control @error('type') is-invalid @enderror" placeholder="Tipe"
                        name="type[]">
                    <button class="btn btn-success" type="button"><i
                            class="fldemo glyphicon glyphicon-plus"></i>Tambah</button>
                </div>
                @error('type')
                <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="clone"></div>
            </div>

        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('infrastruktur.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        // $("#rmv").hide();
        $(".btn-success").click(function () {
            $(".clone").append(`
                <div class="hide mt-3">
                    <div class="input-group hdtuto control-group d-flex justify-content-center">
                        <input type="text" class="form-control @error('type') is-invalid @enderror" placeholder="Tipe" required name="type[]">
                            <button class="btn btn-danger" id="rmv" type="button"><i
                                    class="fldemo glyphicon glyphicon-remove"></i> Hapus</button>
                    </div>
                    @error('type')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            `)
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".hdtuto").remove();
        });
        $("#name").keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });
    });

</script>
@endpush
