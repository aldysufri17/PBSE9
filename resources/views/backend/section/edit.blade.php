@extends('backend.layouts.app')
@section('title','Edit Departemen')
@section('content')
<x-page-form page='edit' route="section.index" title="Departemen">
    <form action="{{route('section.update', $section->section_id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">

            {{-- Name --}}
            <x-form-input label="Nama" type="text" required="required" value="{{$section->name}}" name="name">
            </x-form-input>
        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('section.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection