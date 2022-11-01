@extends('backend.layouts.app')
@section('title','Daftar Infrastruktur')
@section('content')
<x-page-index title="Infrastruktur" buttonLabel="Tambah Infrastruktur" routeCreate="infrastruktur.create">
    @if ($infrastruktur->IsNotEmpty())
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kapasitas</th>
                <th>Kuantitas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($infrastruktur as $data)
            <tr>
                <td>{{$data->infrastruktur->name}}-{{$data->infrastruktur->type}}</td>
                <td>{{$data->capacity}}</td>
                <td>{{$data->quantity}}</td>
                <td>
                    <a href="{{route('infrastruktur.show', $data->post_by)}}" class="table-action btn btn-primary
                        mr-2" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$infrastruktur->links()}}
    @else
    <div class="align-items-center bg-light p-3 border-secondary rounded">
        <span class="">Oops!</span><br>
        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Infrastruktur</p>
    </div>
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
