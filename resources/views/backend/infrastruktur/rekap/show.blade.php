@extends('backend.layouts.app')
@section('title','Daftar Infrastruktur')
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Daftar Infrastruktur</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="/Rekap-infrastruktur">Daftar Departemen</a></div>
            <div class="breadcrumb-item">Daftar Infrastruktur</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card p-3">
            <div class="card-header p-0">
                <h4>Infrastruktur Departemen {{$departemen->user->name}}</h4>
            </div>
            <div class="d-sm-flex align-items-center mb-4">
                <a href="" class="btn btn-sm btn-warning">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>
                <a href="" class="btn btn-sm btn-danger mx-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
            <span class="font-weight-bold">Total Penggunaan Daya :
                {{App\Models\infrastructure_quantity::where('post_by',$departemen->user->user_id)->sum('total')}}
                Watt</span>
            <div class="card-body p-2">
                @if ($infrastruktur->IsNotEmpty())
                <table id="dataTable" class="table table-striped table-borderless responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Gedung</th>
                            <th>Nama Ruangan</th>
                            <th>Nama Barang</th>
                            <th>Kapasitas (Watt)</th>
                            <th>Kuantitas</th>
                            <th>Total Daya (Watt)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($infrastruktur as $key=>$data)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$data->building->name}}</td>
                            <td>{{$data->room->name}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->capacity}}</td>
                            <td>{{$data->quantity}}</td>
                            <td>{{$data->capacity * $data->quantity}}</td>
                            <td>
                                <button class="table-action btn btn-primary edit-btn mr-2" data-toggle="tooltip"
                                    title="Edit" value="{{$data->iq_id}}"><i class="fas fa-pen"></i>
                                </button>
                                <button class="table-action btn btn-danger delete-btn mr-2" data-toggle="tooltip"
                                    title="Delete" value="{{$data->iq_id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#dataTable').DataTable({
            responsive: true
        });

        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
        });

        $(document).on('click', '.edit-btn', function () {
            $('#edit_infrastruktur').modal('show')
            id = $(this).val();
            $.ajax({
                url: 'infrastruktur/admin/Edit',
                method: 'get',
                data: {
                    id: id
                },
                success: function (data) {
                    $("#id").val(data.inf.iq_id);
                    $("#gedung").val(data.gedung);
                    $("#ruangan").val(data.ruangan);
                    $("#barang").val(data.inf.name);
                    $("#kuantitas").val(data.inf.quantity);
                    $("#kapasitas").val(data.inf.capacity);
                }
            });
        });

        $('#edit_infrastruktur_sub').submit(function (e) {
            e.preventDefault();
            var id = $('#id').val();
            var barang = $('#barang').val();
            var kuantitas = $('#kuantitas').val();
            var kapasitas = $('#kapasitas').val();
            $("#edit_infrastruktur_btn").text('Editing...');
            $.ajax({
                url: "admin/infrastruktur/update",
                type: "POST",
                data: {
                    id: id,
                    barang: barang,
                    kuantitas: kuantitas,
                    kapasitas: kapasitas
                },
                success: function (data) {
                    console.log(data);
                    if (data.status == 200) {
                        $('#edit_infrastruktur').modal('hide')
                        window.location.reload();
                    }
                },
            });
        });

    });
</script>
@endpush