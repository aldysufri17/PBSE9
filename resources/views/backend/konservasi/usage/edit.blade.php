@extends('backend.layouts.app')
@section('title','Edit Konservasi')
@section('content')
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
<x-page-form page='edit'
    route="{{auth()->user()->section_id == 128 ? 'konservasi_usage.index_admin' : 'konservasi_usage.index'}}"
    title="Edit Konservasi {{$name}}">
    <form action="{{route('konservasi_usage.update', $usage->cm_id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="post_by" value="{{$post_by}}" hidden>
        <input type="text" name="file_old" value="{{$usage->file}}" hidden>
        <input type="text" name="coi_id" value="{{$usage->coi_id}}" hidden>

        <div class="pb-2">
            <div class="card-header pb-0 bg-white font-weight-bold">
                <h6>{{$usage->conservation_item->name}}</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-sm-0">
                    <label><span style="color:red;">&#8226; </span><span
                            class="font-weight-bold">Ada/Tidak</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" {{$usage->item == 'ada' ? 'checked' : ''}} checked name="item" id="radio" value="ada">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Ada
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" {{$usage->item == 'tidak' ? 'checked' : ''}} name="item" id="radio" value="tidak">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Tidak Ada
                        </label>
                    </div>
                </div>
                <div class="mb-3 mt-3 mb-sm-0">
                    <label><span style="color:red;">&#8226; </span><span
                            class="font-weight-bold">Keterangan</span></label>
                    <textarea class="form-control @error('deskripsi') @enderror"
                        placeholder="Keterangan Pengelolaan Konservasi" name="desc" rows="5"
                        style="height:10%;">{{$usage->desc}}</textarea>
                </div>
                <div class="mb-3 mt-3 mb-sm-0">
                    <label><span style="color:red;">&#8226; </span><span class="font-weight-bold">Berkas
                            Tambahan</span><span class="text-danger">(Max Size:20 MB,
                            jpeg,png,svg,pdf)</span></label>
                    <input type="file" class="form-control form-control-user @error('file') is-invalid @enderror"
                        name="file" value="">
                </div>
            </div>
        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3"
                href="{{auth()->user()->section_id == 128 ? 'konservasi_usage.index_admin' : 'konservasi_usage.index'}}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection