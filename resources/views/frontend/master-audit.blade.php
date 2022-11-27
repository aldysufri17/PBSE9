@extends('frontend.layouts.app')
@section('title', 'Master data Audit')
@section('content')
<x-alert />
<!-- ======= Breadcrumbs Section ======= -->
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold">Master data Audit</h2>
            <ol>
                <li><a href="/">Beranda</a></li>
                <li>Master data Audit</li>
            </ol>
        </div>
    </div>
</section><!-- Breadcrumbs Section -->
<form action="{{route('tahunan.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
        <div class="my-3">
            <h3 class="fw-bold my-4 text-center">MASTER DATA DEPARTEMEN {{strtoupper(auth()->user()->name)}}</h3>
            <div class="civitas">
                <div class="card m-3">
                    <div class="card-body p-3">
                        <div class="justify-content-center">
                            @if ($civitas)
                            @php
                            $incoming_students = array_values(json_decode($civitas->incoming_students, true));
                            $graduate_students = array_values(json_decode($civitas->graduate_students, true));
                            $employee = array_values(json_decode($civitas->employee, true));
                            @endphp
                            @endif
                            <div class="d-flex justify-content-between total font-weight-bold mt-3">
                                <h4 class="fw-bold">DATA CIVITAS AKADEMIKA</h4>
                                <a href="{{route('input.civitas')}}"><span class="badge bg-primary p-2">Ubah</span></a>
                            </div>
                            <div class="masuk">
                                <div class="">
                                    <span class="fw-bold">Mahasiswa Masuk</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">{{$civitas ? $incoming_students[0] : 0}}
                                        Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">{{$civitas ? $incoming_students[1] : 0}}
                                        Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">{{$civitas ? $incoming_students[2] : 0}}
                                        Orang</span>
                                </div>
                                <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span><span
                                        class="durasi">{{$civitas ? array_sum($incoming_students) : 0}}
                                        Orang</span>
                                </div>
                            </div>
                            <div class="masuk mt-3">
                                <div class="">
                                    <span class="fw-bold">Mahasiswa Lulus</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">{{$civitas ? $graduate_students[0] : 0}}
                                        Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">{{$civitas ? $graduate_students[1] : 0}}
                                        Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">{{$civitas ? $graduate_students[2] : 0}}
                                        Orang</span>
                                </div>
                                <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span><span
                                        class="durasi">{{$civitas ? array_sum($graduate_students) : 0}}
                                        Orang</span>
                                </div>
                            </div>
                            <div class="masuk mt-3">
                                <div class="">
                                    <span class="fw-bold">Karyawan (Lab,Tendik,Dosen,Pendukung)</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S1</span><span class="durasi">{{$civitas ? $employee[0] : 0}} Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S2</span><span class="durasi">{{$civitas ? $employee[1] : 0}} Orang</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>S3</span><span class="durasi">{{$civitas ? $employee[2] : 0}} Orang</span>
                                </div>
                                <hr class="my-1" style="color: red; border:1px solid rgb(0, 0, 0)">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span><span class="durasi">{{$civitas ? array_sum($employee) : 0}}
                                        Orang</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-5" style="color: red; border:3px solid blue">
            </div>
            <div class="Gedung">
                <div class="card m-3">
                    <div class="card-body p-3">
                        <div class="justify-content-center">
                            <div class="d-flex justify-content-between total font-weight-bold mt-3">
                                <h4 class="fw-bold">DATA GEDUNG DAN RUANGAN</h4>
                                <a href="{{route('building.add')}}"><span class="badge bg-success p-2">Tambah
                                        Data</span></a>
                            </div>
                            @if ($building->IsNotEmpty())
                            <table id="dataTable" class="table table-striped table-borderless responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Gedung</th>
                                        <th>Total Ruangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($building as $item)
                                    <tr>
                                        @php
                                        $room_count = App\Models\Room::where('building_id',$item->building_id)->count();
                                        @endphp
                                        <td>{{$item->name}}</td>
                                        <td>{{$room_count}} Ruang</td>
                                        <td>
                                            <a href="{{route('building.detail',$item->building_id)}}" class="table-action btn btn-info
                                                mr-2" data-toggle="tooltip" title="Detail"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{route('building.delete',$item->building_id)}}" class="table-action btn btn-danger
                                                        mr-2" data-toggle="tooltip" title="Delete"><i
                                                    class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$building->links()}}
                            @else
                            <h5 class="text-danger fw-bold">Data Gedung Belum ada</h5>
                            @endif
                        </div>
                    </div>
                </div>
                <hr class="my-5" style="color: red; border:3px solid blue">
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#rmv").hide();
        $(".btn-success").click(function () {
            $(".clone").append(`
                <div class="hide mt-3">
                    <div class="input-group hdtuto control-group d-flex justify-content-center">
                        <input type="file" class="form-control" required name="file[]" @error('file') is-invalid @enderror>
                            <div class="input-group-btn">
                            <button class="btn btn-danger" id="rmv" type="button"><i
                                    class="fldemo glyphicon glyphicon-remove"></i> Hapus</button>
                            </div>
                    </div>
                    @error('file')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            `)
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".hdtuto").remove();
        });

        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
            // alert(sid)
        });
    });
</script>
@endpush