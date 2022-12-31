@extends('backend.layouts.app')
@section('title','Tambah Item Legalitas')
@section('content')
<x-page-form page='create' route="index_legalitas.item" title="Item Legalitas">
    <form action="{{route('store_legalitas.item')}}" method="post">
        @csrf
        {{-- nama Item --}}
        <div class="">
            <span style="color:red;">*</span>Item</label>
            <input autocomplete="off" type="text" name="name" id="name"
                class="form-control form-control-user @error('name') is-invalid @enderror" id="examplename"
                placeholder="name">
            @error('item')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('index_legalitas.item') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection
