@extends('backend.layouts.app')
@section('title','Daftar Infrastruktur')
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
            <div class="breadcrumb-item active"><a href="javascript:history.go(-2)">Tahunan</a></div>
            <div class="breadcrumb-item active"><a href="javascript:history.back()">Bulanan</a></div>
            <div class="breadcrumb-item">Bulan {{$monthName}}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header pb-0">
                <h4>Penggunaan Energi Bulan {{$monthName}}</h4>
            </div>
            <div class="card-body p-2">
                @if ($usage->IsNotEmpty())
                <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Enegi</th>
                            <th>Nilai</th>
                            <th>Biaya</th>
                            <th>Tgl Awal</th>
                            <th>Tgl Akhir</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usage as $key=>$data)
                        <tr>
                            @php
                            $energi = App\Models\Energy::where('energy_id',$data->energy_id)->value('name');
                            $unit = App\Models\Energy::where('energy_id',$data->energy_id)->value('unit');
                            @endphp
                            <td>{{$key+1}}</td>
                            <td>{{$energi}}</td>
                            <td>{{$data->usage}} {{$unit}}</td>
                            <td>Rp. {{ number_format($data->cost, 2, ',', '.') }}</td>
                            <td>{{$data->start_date}}</td>
                            <td>{{$data->end_date}}</td>
                            <td><a class="table-action btn btn-primary mr-2"
                                    href="{{asset('file/invoice/'.$data->invoice)}}" target="_blank"><i class="ri-download-line"></i>
                                    Unduh Bukti</a>
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
@include('backend.infrastruktur.modal')
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
