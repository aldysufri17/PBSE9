@extends('backend.layouts.app')
@section('title','Tambah Jenis Energi')
@section('content')
<x-page-form page='create' route="energy.index" title="Jenis Energi">
    <form action="{{route('energy.store')}}" method="post">
        @csrf
        <div class="form-group row">

            {{-- Name --}}
            <x-form-input label="Nama" type="text" required="required" name="name"></x-form-input>

            {{-- Email --}}
            <x-form-input label="Satuan" type="text" required="required" name="unit"></x-form-input>

        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('energy.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection
