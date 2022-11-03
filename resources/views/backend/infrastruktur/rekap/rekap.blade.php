@extends('backend.layouts.app')
@section('title','Daftar Infrastruktur')
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Infrastruktur Tahunan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="/Rekap-infrastruktur">Daftar Infrastruktur</a></div>
            <div class="breadcrumb-item">Tahunan</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header pb-0">
                <h4>Daftar Infrastruktur Tahunan {{$year}}</h4>
            </div>
            <div class="card-body p-2">
                @if ($infrastruktur->IsNotEmpty())
                <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kapasitas</th>
                            <th>Kuantitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($infrastruktur as $data)
                        <tr>
                            <td>{{$data->infrastruktur->name}}-{{$data->infrastruktur->type}}</td>
                            <td>{{$data->capacity}}</td>
                            <td>{{$data->quantity}}</td>
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
            </div>
        </div>
    </div>
</section>
{{-- @include('backend.infrastruktur.modal') --}}
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true
        });

        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
            // alert(sid)
        });
    });

</script>
@endpush
