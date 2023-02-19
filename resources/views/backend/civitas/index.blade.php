@extends('backend.layouts.app')
@section('title','Daftar Civitas Akademik')
@section('content')
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
<x-page-index title="{{auth()->user()->section_id == 128 ? 'Civitas Akademik': 'Civitas Akademik '.$name}}"
    buttonLabel="Tambah Civitas Akademik" routeCreate="{{auth()->user()->section_id == 128 ? '':'civitas.create'}}">
    @if (auth()->user()->section_id != 128)
    @if ($civitas->IsNotEmpty())
    <!--<div class="d-sm-flex align-items-center mb-4">
        <a href="#" target="_blank" class="btn btn-sm btn-warning" title="unduh csv">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </div>-->
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun Rekap</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($civitas as $key => $data)
            <tr>
                @php
                $name = App\Models\User::where('user_id',$data->post_by)->value('name');
                @endphp
                <td>{{$key+1}}</td>
                <td>{{$data->year}}</td>
                <td>
                    <a href="{{route('civitas.show',[$data->year,$data->post_by])}}" class="table-action btn btn-primary
                        mr-2" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                    <a href="{{route('civitas.history',[$data->year,$data->post_by])}}" class="table-action btn btn-warning
                            mr-2" data-toggle="tooltip" title="History"><i class="fas fa-clock"></i></a>
                    <a href="{{route('civitas.export', [$year,$data->post_by])}}" target="_blank" class="btn btn-sm btn-warning" title="unduh csv">
                        <i class="fas fa-file-csv"></i> Export
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="align-items-center bg-light p-3 border-secondary rounded">
        <span class="">Oops!</span><br>
        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Civitas Akademik</p>
    </div>
    @endif
    @else
    @if ($civitas->IsNotEmpty())
    <div class="d-sm-flex align-items-center mb-4">
        <a href="#" target="_blank" class="btn btn-sm btn-warning" title="unduh csv">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </div>
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Departemen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($civitas as $key=>$data)
            <tr>
                @php
                $name = App\Models\User::where('user_id', $data->post_by)->value('name');
                @endphp
                <td>{{$key+1}}</td>
                <td>{{$name}}</td>
                <td>
                    <a href="{{route('civitas.show',[$year,$data->post_by])}}" class="table-action btn btn-primary
                        mr-2" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="align-items-center bg-light p-3 border-secondary rounded">
        <span class="">Oops!</span><br>
        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Civitas</p>
    </div>
    @endif
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