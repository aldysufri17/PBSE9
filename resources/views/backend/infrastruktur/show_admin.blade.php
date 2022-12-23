@extends('backend.layouts.app')
@section('title','Penggunaan Infrastruktur')
@section('content')
<x-page-index title="Penggunaan Infrastruktur" buttonLabel="Tambah Rekap" routeCreate="">
    @if ($infrastruktur->IsNotEmpty())
    <div class="d-sm-flex align-items-center mb-4">
        <a href="#" target="_blank" class="btn btn-sm btn-warning" title="unduh csv">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </div>
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Total Penggunaan Energi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($infrastruktur as $key=>$data)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$data->year}}</td>
                <td><b>{{$data->total}} Watt</b></td>
                <td>
                    <div class="table-actions btn-group">
                        <a href="{{route('infrastruktur.edit', [$data->year,$data->post_by])}}" class="table-action btn btn-primary
                        mr-2" data-toggle="tooltip" title="Ubah"><i class="fas fa-edit"></i></a>
                        <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                            value="{{$data->post_by}}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <input type="text" hidden value="{{$data->year}}" id="year">
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</x-page-index>
@include('backend.infrastruktur.modal')
@endsection

@push('scripts')
<script>
    $(document).on('click', '.delete-btn', function () {
        var sid = $(this).val();
        var syear = $('#year').val();
        $('#deleteModal').modal('show')
        $('#delete_id').val(sid)
        $('#delete_year').val(syear)
        // alert(sid)
    });
</script>
@endpush