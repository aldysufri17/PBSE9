@extends('backend.layouts.app')
@section('title','Penggunaan Infrastruktur')
@section('content')
<x-page-index title="Penggunaan Infrastruktur" buttonLabel="Tambah Rekap" routeCreate="{{auth()->user()->section_id == 128 ? '':'infrastruktur.create'}}">
    @if (Auth::user()->section_id != 128)
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
                    <a href="{{route('infrastruktur.export', [$data->post_by,$data->year,])}}" target="_blank" class="btn btn-sm btn-warning" title="unduh csv">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </a>
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
    @else
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
                <th>Nama Departemen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($infrastruktur as $key=>$data)
            <tr>
                @php
                $name = App\Models\User::where('user_id', $data->post_by)->value('name');
                @endphp
                <td>{{$key+1}}</td>
                <td>{{$name}}</td>
                <td>
                    <a href="{{route('infrastruktur.show', $data->post_by)}}" class="table-action btn btn-primary
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