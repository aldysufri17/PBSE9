@extends('backend.layouts.app')
@section('title','Daftar Post')
@section('content')
<x-page-index title="Post" buttonLabel="Tambah Post" routeCreate="post.create">
    @if ($posts->IsNotEmpty())
    <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis Energi</th>
                <th>Nilai Energi</th>
                <th>Waktu Awal Penggunaan</th>
                <th>Waktu Akhir Penggunaan</th>
                <th>Data Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td>{{$post->user->name}}</td>
                <td>{{$post->energy->name}}</td>
                <td>{{$post->usage}} {{$post->energy->satuan}}</td>
                <td>{{$post->start_date}}</td>
                <td>{{$post->end_date}}</td>
                <td class="text-center">{{$post->created_at->format('d M Y')}}
                    <strong class="text-muted">({{$post->created_at->format('H:i:s A')}})</strong></td>
                <td>
                    <div class="table-actions btn-group">
                        <a href="{{route('post.edit',$post->id)}}" class="table-action btn btn-primary mr-2"
                            data-toggle="tooltip" title="Ubah">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip" title="Delete"
                            value="{{$post->id}}">
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
        <p><i class="fas fa-info-circle"></i> Belum Terdapat Data Post</p>
    </div>
    @endif
</x-page-index>
@include('backend.posts.modal')
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
