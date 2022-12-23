@extends('backend.layouts.app')
@if (auth()->user()->section_id == 128)
@section('title',"Daftar Bagian")
@else
@section('title',"Daftar Gedung")
@endif
@section('content')
<x-page-index title="{{auth()->user()->section_id == 128 ? 'Bagian' : 'Gedung'}}" buttonLabel="Tambah Gedung"
    routeCreate="{{auth()->user()->section_id == 128 ? '':'building.create'}}">
    @if (auth()->user()->section_id != 128)
    @if ($building->IsNotEmpty())
    <div class="d-sm-flex align-items-center mb-4">
        <a href="#" target="_blank" class="btn btn-sm btn-warning" title="unduh csv">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </div>
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Gedung</th>
                <th>Departemen</th>
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
                    <a href="{{route('building.show', $data->building_id)}}" class="table-action btn btn-primary
                        mr-2" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                    <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                        value="{{$data->building_id}}">
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
    @else
    @if ($building->IsNotEmpty())
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bagian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($building as $key=>$data)
            <tr>
                @php
                $name = App\Models\Section::where('section_id', $data->section_id)->value('name');
                @endphp
                <td>{{$key+1}}</td>
                <td>{{$name}}</td>
                <td>
                    <a href="{{route('building.show', $data->section_id)}}" class="table-action btn btn-primary
                        mr-2" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="align-items-center bg-light p-3 border-secondary rounded">
        <span class="">Oops!</span><br>
        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Infrastruktur</p>
    </div>
    @endif
    @endif
</x-page-index>
@include('backend.building.modal')
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