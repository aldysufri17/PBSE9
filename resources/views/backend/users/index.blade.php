@extends('backend.layouts.app')
@section('title','Daftar Akun')
@section('content')
@if ($user->IsNotEmpty())
<x-page-index title="Akun" buttonLabel="Tambah Akun" routeCreate="user.create">
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Departemen</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $key=>$data)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->email}}</td>
                <td>
                    @if ($data->section_id == 128)
                    Admin
                    @else
                    {{$data->section->name }}
                    @endif
                </td>
                <td>
                    @if ($data->role_id == 128)
                    <span class="badge badge-primary">Admin</span>
                    @elseif($data->role_id == 4)
                    <span class="badge badge-warning">Auditor</span>
                    @else
                    <span class="badge badge-info">Pengguna</span>
                    @endif
                </td>
                <td>
                    @if ($data->status == 0)
                    <span class="badge badge-danger" title="User Inactive">Inactive</span>
                    @else
                    <span class="badge badge-success" title="User is Active">Active</span>
                    @endif
                </td>
                <td>
                    <div class="table-actions btn-group">
                        @if ($data->status == 0)
                        <a href="{{ route('user.status', ['user_id' => encrypt($data->user_id), 'status' => 1]) }}"
                            title="Set Active" class="table-action btn btn-success mr-2" data-toggle="tooltip">
                            <i class="fa fa-check"></i>
                        </a>
                        @else
                        <a href="{{ route('user.status', ['user_id' => encrypt($data->user_id), 'status' => 0]) }}"
                            title="Set Inactive" class="table-action btn btn-danger mr-2" data-toggle="tooltip">
                            <i class="fa fa-ban"></i>
                        </a>
                        @endif
                        <button class="table-action btn btn-warning reset-btn mr-2" title="Reset Password"
                            data-toggle="tooltip" value="">
                            <i class="fas fa-history"></i>
                        </button>
                        <!--<a href="" class="table-action btn btn-info mr-2" data-toggle="tooltip" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>-->
                        <a href="{{route('user.edit',$data->user_id)}}" class="table-action btn btn-primary mr-2"
                            data-toggle="tooltip" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                            value="{{$data->user_id}}">
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
    <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Pengguna</p>
</div>
@endif
@include('backend.users.modal')
@endsection

@push('scripts')
<script>
    $(document).on('click', '.delete-btn', function () {
        var sid = $(this).val();
        $('#deleteModal').modal('show')
        $('#delete_id').val(sid)
        // alert(sid)
    });

    $(document).on('click', '.reset-btn', function () {
        var rid = $(this).val();
        $('#resetModal').modal('show')
        $('#reset_id').val(rid)
        // alert(sid)
    });

</script>
@endpush
