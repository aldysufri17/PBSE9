@extends('backend.layouts.app')
@section('title','Daftar Jenis Energi')
@section('content')
<x-page-index title="Jenis Energi" buttonLabel="Tambah Jenis Energi" routeCreate="energy.create">
    @if ($energy->IsNotEmpty())
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($energy as $key=>$data)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->unit}}</td>
                <td>
                    <div class="table-actions btn-group">
                        <a href="{{route('energy.edit',$data->energy_id)}}" class="table-action btn btn-primary mr-2"
                            data-toggle="tooltip" title="Ubah">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                            value="{{$data->energy_id}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="align-items-center bg-light p-3 border-secondary rounded">
        <span class="">Oops!</span><br>
        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Energi</p>
    </div>
    @endif
</x-page-index>
@include('backend.energy.modal')
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
