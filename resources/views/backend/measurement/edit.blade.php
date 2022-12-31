@extends('backend.layouts.app')
@section('title','Ubah Kualitas Daya')
@section('content')
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="javascript:history.back()" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Ubah Kualitas Daya {{$name}} Tahun {{$year}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="/measurement">Daftar Kualitas Daya</a></div>
            <div class="breadcrumb-item active">Ubah Kualitas Daya</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card my-5">
            <form action="{{route('measurement.update',$measurement->m_id)}}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="ili_id" value="{{$measurement->m_id}}" hidden>
                <input type="text" name="year" value="{{$year}}" hidden>
                <input type="text" name="post_by" value="{{$measurement->post_by}}" hidden>
                <div class="card">
                    <div class="card-body">
                        <div class="konservasi">
                            <h4 class="font-weight-bold text-center mt-5">EDIT KUALITAS DAYA TAHUN {{$year}}</h4>
                            @php
                            $daya_aktif = array_values(json_decode($measurement->daya_aktif, true));
                            $daya_reaktif = array_values(json_decode($measurement->daya_reaktif, true));
                            $daya_semu = array_values(json_decode($measurement->daya_semu, true));
                            $satu_fasa = array_values(json_decode($measurement->tegangan_satu_fasa, true));
                            $tiga_fasa = array_values(json_decode($measurement->tegangan_tiga_fasa, true));
                            $unbalance = array_values(json_decode($measurement->tegangan_tidak_seimbang, true));
                            $arus = array_values(json_decode($measurement->arus, true));
                            @endphp
                            <div class="items">
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">1. Daya Aktif</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        R</span></label>
                                                <input type="number" placeholder="Fasa R" value="{{$daya_aktif[0]}}" required
                                                    class="form-control form-control-user @error('R[0]') is-invalid @enderror"
                                                    name="R[0]">
                                                @error('R[0]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        S</span></label>
                                                <input type="number" placeholder="Fasa S" required value="{{$daya_aktif[1]}}"
                                                    class="form-control form-control-user @error('S[0]') is-invalid @enderror"
                                                    name="S[0]" value="">
                                                @error('S[0]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        T</span></label>
                                                <input type="number" placeholder="Fasa T" required value="{{$daya_aktif[2]}}"
                                                    class="form-control form-control-user @error('T[0]') is-invalid @enderror"
                                                    name="T[0]" value="">
                                                @error('T[0]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2 mx-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Total</span></label>
                                                <input type="number" placeholder="Total" required value="{{$daya_aktif[3]}}"
                                                    class="form-control form-control-user @error('DT[0]') is-invalid @enderror"
                                                    name="DT[0]" value="">
                                                @error('DT[0]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">2. Daya Reaktif</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        R</span></label>
                                                <input type="number" placeholder="Fasa R" required value="{{$daya_reaktif[0]}}"
                                                    class="form-control form-control-user @error('R[1]') is-invalid @enderror"
                                                    name="R[1]">
                                                @error('R[1]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        S</span></label>
                                                <input type="number" placeholder="Fasa S" required value="{{$daya_reaktif[1]}}"
                                                    class="form-control form-control-user @error('S[1]') is-invalid @enderror"
                                                    name="S[1]" value="">
                                                @error('S[1]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        T</span></label>
                                                <input type="number" placeholder="Fasa T" required value="{{$daya_reaktif[2]}}"
                                                    class="form-control form-control-user @error('T[1]') is-invalid @enderror"
                                                    name="T[1]" value="">
                                                @error('T[1]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2 mx-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Total</span></label>
                                                <input type="number" placeholder="Total" required value="{{$daya_reaktif[3]}}"
                                                    class="form-control form-control-user @error('DT[1]') is-invalid @enderror"
                                                    name="DT[1]" value="">
                                                @error('DT[1]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">3. Daya Semu</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        R</span></label>
                                                <input type="number" placeholder="Fasa R" required value="{{$daya_semu[0]}}"
                                                    class="form-control form-control-user @error('R[2]') is-invalid @enderror"
                                                    name="R[2]">
                                                @error('R[2]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        S</span></label>
                                                <input type="number" placeholder="Fasa S" required value="{{$daya_semu[1]}}"
                                                    class="form-control form-control-user @error('S[2]') is-invalid @enderror"
                                                    name="S[2]" value="">
                                                @error('S[2]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        T</span></label>
                                                <input type="number" placeholder="Fasa T" required value="{{$daya_semu[2]}}"
                                                    class="form-control form-control-user @error('T[2]') is-invalid @enderror"
                                                    name="T[2]" value="">
                                                @error('T[2]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2 mx-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Total</span></label>
                                                <input type="number" placeholder="Total" required value="{{$daya_semu[3]}}"
                                                    class="form-control form-control-user @error('DT[2]') is-invalid @enderror"
                                                    name="DT[2]" value="">
                                                @error('DT[2]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">4. Tegangan 1 Fasa</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>R-N</span></label>
                                                <input type="number" placeholder="V R-N" required value="{{$satu_fasa[0]}}"
                                                    class="form-control form-control-user @error('VRN') is-invalid @enderror"
                                                    name="VRN">
                                                @error('VRN')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>S-N</span></label>
                                                <input type="number" placeholder="V S-N" required value="{{$satu_fasa[1]}}"
                                                    class="form-control form-control-user @error('VSN') is-invalid @enderror"
                                                    name="VSN" value="">
                                                @error('VSN')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>T-N</span></span></label>
                                                <input type="number" placeholder="V T-N" required value="{{$satu_fasa[2]}}"
                                                    class="form-control form-control-user @error('VTN') is-invalid @enderror"
                                                    name="VTN" value="">
                                                @error('VTN')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">5. Tegangan 3 Fasa</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>RS</span></label>
                                                <input type="number" placeholder="VRS" required value="{{$tiga_fasa[0]}}"
                                                    class="form-control form-control-user @error('VRS[0]') is-invalid @enderror"
                                                    name="VRS[0]">
                                                @error('VRS[0]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>ST</span></label>
                                                <input type="number" placeholder="VST" required value="{{$tiga_fasa[1]}}"
                                                    class="form-control form-control-user @error('VST[0]') is-invalid @enderror"
                                                    name="VST[0]" value="">
                                                @error('VST[0]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>TR</span></span></label>
                                                <input type="number" placeholder="VTR" required value="{{$tiga_fasa[2]}}"
                                                    class="form-control form-control-user @error('VTR[0]') is-invalid @enderror"
                                                    name="VTR[0]" value="">
                                                @error('VTR[0]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">6. Tegangan Tidak Seimbang</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>RS</span></label>
                                                <input type="number" placeholder="VRS" required value="{{$unbalance[0]}}"
                                                    class="form-control form-control-user @error('VRS[1]') is-invalid @enderror"
                                                    name="VRS[1]">
                                                @error('VRS[1]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>ST</span></label>
                                                <input type="number" placeholder="VST" required value="{{$unbalance[1]}}"
                                                    class="form-control form-control-user @error('VST[1]') is-invalid @enderror"
                                                    name="VST[1]" value="">
                                                @error('VST[1]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold"><span
                                                            style="font-size: 20px">V</span>TR</span></span></label>
                                                <input type="number" placeholder="VTR" required value="{{$unbalance[2]}}"
                                                    class="form-control form-control-user @error('VTR[1]') is-invalid @enderror"
                                                    name="VTR[1]" value="">
                                                @error('VTR[1]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">7. Arus</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        R</span></label>
                                                <input type="number" placeholder="Fasa R" required value="{{$arus[0]}}"
                                                    class="form-control form-control-user @error('R[3]') is-invalid @enderror"
                                                    name="R[3]">
                                                @error('R[3]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mx-3 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        S</span></label>
                                                <input type="number" placeholder="Fasa S" required value="{{$arus[1]}}"
                                                    class="form-control form-control-user @error('S[3]') is-invalid @enderror"
                                                    name="S[3]" value="">
                                                @error('S[3]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Fasa
                                                        T</span></label>
                                                <input type="number" placeholder="Fasa T" required value="{{$arus[2]}}"
                                                    class="form-control form-control-user @error('T[3]') is-invalid @enderror"
                                                    name="T[3]" value="">
                                                @error('T[3]')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Netral</span></label>
                                                <input type="number" placeholder="Fasa T" required value="{{$arus[3]}}"
                                                    class="form-control form-control-user @error('n') is-invalid @enderror"
                                                    name="n" value="">
                                                @error('n')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">8. Frekuensi</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Value</span></label>
                                                <input type="number" placeholder="Frekuensi" required value="{{$measurement->frekuensi}}"
                                                    class="form-control form-control-user @error('f') is-invalid @enderror"
                                                    name="f">
                                                @error('f')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">9. Harmonisa Arus</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Value</span></label>
                                                <input type="number" placeholder="Harmonisa Arus" required value="{{$measurement->harmonisa_arus}}"
                                                    class="form-control form-control-user @error('ha') is-invalid @enderror"
                                                    name="ha">
                                                @error('ha')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">10. Harmonisa Tegangan</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Value</span></label>
                                                <input type="number" placeholder="Harmonisa Tegangan" required value="{{$measurement->harmonisa_tegangan}}"
                                                    class="form-control form-control-user @error('ht') is-invalid @enderror"
                                                    name="ht">
                                                @error('ht')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5">
                                    <h5 class="font-weight-bold">11. Faktor Daya</h5>
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body pt-0 row">
                                            <div class="mb-2 mb-sm-0 mt-2">
                                                <label><span style="color:red;">&#8226; </span><span
                                                        class="font-weight-bold">Value</span></label>
                                                <input type="number" placeholder="Faktor Daya" required value="{{$measurement->faktor_daya}}"
                                                    class="form-control form-control-user @error('fd') is-invalid @enderror"
                                                    name="fd">
                                                @error('fd')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right border-0">
                        <a class="btn btn-danger mr-3" href="{{ route('measurement.index') }}">Batal</a>
                        <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection