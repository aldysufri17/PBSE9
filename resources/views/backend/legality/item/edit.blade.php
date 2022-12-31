@extends('backend.layouts.app')
@section('title','Edit Item Legalitas')
@section('content')
<x-page-form page='edit' route="index_legalitas.item" title="Item Legalitas">
    <form action="{{route('update_legalitas.item', $item->ili_id)}}" method="POST">
        @csrf
        <div class="form-group row">

            {{-- Name --}}
            <x-form-input label="Nama" type="text" required="required" value="{{$item->item}}" name="name">
            </x-form-input>

        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('index_legalitas.item') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection