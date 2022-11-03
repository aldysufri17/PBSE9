@extends('backend.layouts.app')
@section('title','Tambah Jenis Konservasi')
@section('content')
<x-page-form page='create' route="konservasi.index" title="Jenis Konservasi">
    <form action="{{route('konservasi.store')}}" method="post">
        @csrf
        {{-- Name --}}
        <div class="">
            <span style="color:red;">*</span>Item</label>
            <input autocomplete="off" type="text" name="item" id="item"
                class="form-control form-control-user @error('item') is-invalid @enderror" id="exampleitem"
                placeholder="item">
            @error('item')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('konservasi.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection
