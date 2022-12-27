@extends('backend.layouts.app')
@section('title','Daftar Civitas Akademik')
@section('content')
@php
    $name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
<x-page-index title="Civitas Akademik {{$name}}" buttonLabel="Tambah Civitas Akademik"
    routeCreate="{{auth()->user()->section_id == 128 ? '':'civitas.create'}}">
    <div class="section-header-back">
        <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    @if ($civitas->IsNotEmpty())
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
                    <a href="{{route('civitas.detailAdmin',[$data->year,$data->post_by])}}" class="table-action btn btn-primary
                        mr-2" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
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