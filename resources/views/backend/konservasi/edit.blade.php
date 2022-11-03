@extends('backend.layouts.app')
@section('title','Edit Item Konservasi')
@section('content')
<x-page-form page='edit' route="konservasi.index" title="Item Konservasi">
    <form action="{{route('konservasi.update', $konservasi->coi_id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">

            {{-- Name --}}
            <x-form-input label="Nama" type="text" required="required" value="{{$konservasi->name}}" name="name">
            </x-form-input>

        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('konservasi.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection