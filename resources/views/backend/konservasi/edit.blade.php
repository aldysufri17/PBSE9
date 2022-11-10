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

            <div class="mt-2">
                <span style="color:red;">*</span>Kategori</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="category"
                        id="radio" value="1" {{$konservasi->category == 1 ? 'checked': ''}}>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Bulanan
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" {{$konservasi->category == 0 ? 'checked': ''}} type="radio"
                        name="category" id="radio" value="0">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Tahunan
                    </label>
                </div>
            </div>

        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('konservasi.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection