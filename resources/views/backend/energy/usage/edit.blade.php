@extends('backend.layouts.app')
@section('title','Edit Penggunaan Energi')
@section('content')
@php
$name = App\Models\User::where('user_id',$post_by)->value('name');
@endphp
<x-page-form page='edit' route="energy-usage.index" title="Edit Penggunaan Energi {{$name}}">
    <form action="{{route('energy-usage.update', $usage->eu_id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" name="post_by" value="{{$post_by}}" hidden>
        <input type="text" name="energy" value="{{$usage->energy_id}}" hidden>
        <div class="form-group row">
            {{-- Nilai Energi --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Nilai Penggunaan</label>
                <div class="input-group">
                    <input required type="number" placeholder="Nilai Penggunaan"
                        class="form-control form-control-user @error('usage') is-invalid @enderror" name="usage"
                        value="{{ $usage->usage }}">
                    <span class="input-group-text">{{$usage->energy->unit}}</span>
                </div>
                @error('usage')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {{-- Nilai Energi --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Biaya Penggunaan</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input required type="text" id="cost" placeholder="Biaya Penggunaan"
                        class="form-control form-control-user @error('cost') is-invalid @enderror" name="cost"
                        value="{{ $usage->cost }}"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                </div>
                @error('cost')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {{-- Tanggal Awal Penggunaan --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Tanggal Awal Penggunaan</label>
                <input required type="date"
                    class="form-control form-control-user @error('start_date') is-invalid @enderror" name="start_date"
                    value="{{ $usage->start_date }}">
                @error('start_date')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {{-- Tanggal Akhir Penggunaan --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Tanggal Akhir Penggunaan</label>
                <input required type="date"
                    class="form-control form-control-user @error('end_date') is-invalid @enderror" name="end_date"
                    value="{{ $usage->end_date }}">
                @error('end_date')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {{-- Tanggal Penggunaan --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Bukti Penggunaan <span class="text-danger">(Max
                    Size
                    :20 MB, jpeg,png,svg,pdf)</span></label>
                <input required type="file"
                    class="form-control form-control-user @error('invoice') is-invalid @enderror" name="invoice"
                    value="{{ $usage->invoice }}">
                @error('invoice')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ Auth::user()->section_id != 128 ? route('energy-usage.index') : route('energy-usage.index_admin') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection