@extends('backend.layouts.app')
@section('title','Edit Jenis Energi')
@section('content')
<x-page-form page='edit' route="energy.index" title="Jenis Energi">
    <form action="{{route('energy.update', $energy->energy_id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">

            {{-- Name --}}
            <x-form-input label="Nama" type="text" required="required" value="{{$energy->name}}" name="name">
            </x-form-input>

            {{-- Email --}}
            <x-form-input label="Satuan" type="text" required="required" value="{{$energy->unit}}" name="unit">
            </x-form-input>

        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('energy.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection