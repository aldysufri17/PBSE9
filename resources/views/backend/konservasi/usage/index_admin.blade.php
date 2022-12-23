@extends('backend.layouts.app')
@section('title','Daftar Departemen')
@section('content')
<x-page-index title="Daftar Departemen"
    buttonLabel="Tambah Pengelola Konservasi" routeCreate="">
    @if ($usage->IsNotEmpty())
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Departemen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usage as $key=>$data)
            <tr>
                @php
                $name = App\Models\User::where('user_id',$data->post_by)->value('name');
                @endphp
                <td>{{$key+1}}</td>
                <td>{{$name}}</td>
                <td>
                    <form action="{{route('konservasi_usage.index')}}" method="get">
                        <button type="submit" class="table-action btn btn-primary mr-2" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></button>
                        <input type="text" name="post_by" hidden value="{{$data->post_by}}">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="align-items-center bg-light p-3 border-secondary rounded">
        <span class="">Oops!</span><br>
        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Pengelola Konservasi</p>
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