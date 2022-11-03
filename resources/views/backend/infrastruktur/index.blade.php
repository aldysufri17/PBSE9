@extends('backend.layouts.app')
@section('title','Daftar Infrastruktur')
@section('content')
<x-page-index title="Infrastruktur" buttonLabel="Tambah Infrastruktur" routeCreate="infrastruktur.create">
    @if ($infrastruktur->IsNotEmpty())
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($infrastruktur as $data)
            <tr>
                <td>{{$data->name}}</td>
                <td>
                    @php
                    $types = App\Models\infrastructure::where('name',$data->name)->get();
                    @endphp
                    <ol>
                        @foreach ($types as $data)
                        <li>{{$data->type}}</li>
                        @endforeach
                    </ol>
                </td>
                <td>
                    <div class="table-actions btn-group">
                        <a href="{{route('infrastruktur.edit', $data->name)}}" class="table-action btn btn-primary
                        mr-2" data-toggle="tooltip" title="Ubah"><i class="fas fa-edit"></i></a>
                        <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                            value="{{$data->name}}">
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
        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Infrastruktur</p>
    </div>
    @endif
</x-page-index>
@include('backend.infrastruktur.modal')
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
