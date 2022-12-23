@extends('backend.layouts.app')
@section('title','Penggunaan Infrastruktur')
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('infrastruktur.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Rekap Data</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('infrastruktur.index')}}">Daftar Infrastruktur</a></div>
            <div class="breadcrumb-item">Rekap Penggunaan Infrastruktur</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body pt-0">
                <h4 class="text-center pt-4">Penggunaan Infrastruktur Tahun {{$year}}</h4>
                <form action="{{route('infrastruktur.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <span class="font-weight-bold">Name Departemen</span>
                        <select id="select" class="form-control selectpicker form-control-user @error('user') is-invalid @enderror"
                            name="building">
                            <option disabled selected>---Pilih Departemen---</option>
                            @foreach ($building as $data)
                            <option value="{{$data->building_id}}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <input type="text" id="id" name="post_by" value="{{$post_by}}" hidden>
                    <input type="text" name="year" value="{{$year}}" id="year" hidden>
                    <div class="form-group">
                        <span class="font-weight-bold">Nama Ruangan</span>
                        <select id="room" required class="form-control selectroom room" name="room">
                        </select>
                    </div>
                    <div class="form-group inf-area">
                        <span class="font-weight-bold mb-2">Rekap Infrastruktur</span>
                        <div class="infrastruktur-parent"></div>
                    </div>
                    <div class="clone"></div>
                    <div class="card-footer text-right border-0">
                        <a class="btn btn-danger mr-3" href="{{ route('infrastruktur.index') }}">Batal</a>
                        <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#rmv").hide();
        $(document).on('click', '.btn-success', function () {
            $(".clone").append(`
            <div class="infrastruktur hdtuto d-flex justify-content-between my-2 total font-weight-bold">
                <div class="col">
                    <span class="font-weight-bold">Nama Infrastruktur</span>
                    <input required type="text" placeholder="Nama Infrastruktur"
                        class="form-control form-control-user @error('inf') is-invalid @enderror" name="inf[]"
                        value="">
                    @error('inf')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col mx-2">
                    <span class="font-weight-bold">Kapasitas (Watt)</span>
                    <input required type="number" placeholder="Kapasitas"
                        class="form-control form-control-user @error('cty') is-invalid @enderror" name="cty[]"
                        value="">
                    @error('cty')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col">
                    <span class="font-weight-bold">Kuantitas</span>
                    <input required type="number" placeholder="Kuantitas"
                        class="form-control form-control-user @error('qty') is-invalid @enderror" name="qty[]"
                        value="">
                    @error('qty')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <button class="btn btn-danger" id="rmv" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Hapus</button>
            </div>
            `)
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".hdtuto").remove();
        });
        $("#name").keyup(function () {
            $(this).val($(this).val().toUpperCase());
        });

        $(".inf-area").hide();
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
                                '<option disabled selected>---Pilih Ruangan---</option>'
                            );
                            $.each(data, function (key, room) {
                                $('select[name="room"]').append(
                                    '<option value="' + room
                                    .room_id + '">' + room.name +
                                    '</option>');
                            })
                        } else {
                            $('#room').empty()
                        }
                    }
                });
            });

            $(document).on('change', '.selectroom', function () {
                var select = $('#room option:selected').val()
                var year = $('#year').val();
                var id = $('#id').val();
                $.ajax({
                    url: "{{ route('roomInfrastruktur.ajax') }}",
                    type: "GET",
                    data: {
                        select: select,
                        year: year,
                        id: id
                    },
                    success: function (data) {
                        if (data.cekNull == '0') {
                            $(".inf-area").show();
                            $(".infrastruktur-parent").html(`
                            <div class="infrastruktur hdtuto d-flex justify-content-between my-2 total font-weight-bold">
                                <div class="col">
                                    <span class="font-weight-bold">Nama Infrastruktur</span>
                                    <input required type="text" placeholder="Nama Infrastruktur"
                                        class="form-control form-control-user @error('inf') is-invalid @enderror" name="inf[]"
                                        value="">
                                    @error('inf')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col mx-2">
                                    <span class="font-weight-bold">Kapasitas (Watt)</span>
                                    <input required type="number" placeholder="Kapasitas"
                                        class="form-control form-control-user @error('cty') is-invalid @enderror" name="cty[]"
                                        value="">
                                    @error('cty')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">Kuantitas</span>
                                    <input required type="number" placeholder="Kuantitas"
                                        class="form-control form-control-user @error('qty') is-invalid @enderror" name="qty[]"
                                        value="">
                                    @error('qty')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <span class="font-weight-bold">Total Daya</span>
                                    <input required type="number" placeholder="Total Daya"
                                        class="form-control form-control-user @error('total') is-invalid @enderror" name="total[]"
                                        value="">
                                    @error('total')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-success btn-add" type="button">Tambah</button>
                            </div>
                            `);
                        } else {
                            $(".inf-area").show();
                            $('.infrastruktur-parent').html(data.output)
                        }

                    }
                });
            });
        });
    });
</script>
@endpush