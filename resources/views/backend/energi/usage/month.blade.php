@extends('backend.layouts.app')
@section('title','Daftar Penggunaan Energi Bulanan')
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Energi Bulanan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="/energi-usage">Daftar Penggunaan Energi</a></div>
            <div class="breadcrumb-item active"><a href="javascript:history.back()">Tahunan</a></div>
            <div class="breadcrumb-item">Bulanan</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header pb-0">
                <h4>Daftar Penggunaan Energi Bulanan</h4>
            </div>
            <div class="card-body p-2">
                @if ($usage->IsNotEmpty())
                <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Bulan Input</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usage as $data)
                        <tr>
                            @php
                            $monthNum = $data->month;
                            $dateObj = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F');
                            @endphp
                            <td>{{$monthName}}</td>
                            <td>
                                <a href="{{route('energi_usage.show', ['id'=>$data->post_by,'year'=>$year,'month'=>$data->month])}}"
                                    class="table-action btn btn-primary
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
