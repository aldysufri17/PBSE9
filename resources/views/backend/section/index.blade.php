@extends('backend.layouts.app')
@section('title','Daftar Section')
@section('content')
@if ($section->IsNotEmpty())
<x-page-index title="Section" buttonLabel="Tambah Section" routeCreate="section.create">
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Nama Section</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($section as $data)
            <tr>
                <td>{{$data->name}}</td>
                <td>
                    <div class="table-actions btn-group">
                        <a href="{{route('section.edit',$data->section_id)}}" class="table-action btn btn-primary mr-2"
                            data-toggle="tooltip" title="Ubah">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                            value="{{$data->section_id}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-page-index>
@else
<div class="align-items-center bg-light p-3 border-secondary rounded">
    <span class="">Oops!</span><br>
    <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Section</p>
</div>
@endif
@include('backend.section.modal')
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
