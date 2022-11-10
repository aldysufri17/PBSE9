@extends('backend.layouts.app')
@section('title','Tambah Item Konservasi')
@section('content')
<x-page-form page='create' route="konservasi.index" title="Item Konservasi">
    <form action="{{route('konservasi.store')}}" method="post">
        @csrf
        {{-- Name --}}
        <div class="">
            <span style="color:red;">*</span>Item</label>
            <input autocomplete="off" type="text" name="name" id="name"
                class="form-control form-control-user @error('name') is-invalid @enderror" id="examplename"
                placeholder="name">
            @error('item')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="mt-2">
            <span style="color:red;">*</span>Kategori</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category"
                    id="radio" value="1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Bulanan
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" checked type="radio"
                    name="category" id="radio" value="0">
                <label class="form-check-label" for="flexRadioDefault2">
                    Tahunan
                </label>
            </div>
        </div>

        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('konservasi.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection
