@extends('backend.layouts.app')
@section('title','Tambah Post')
@section('content')
<x-page-form page='create' route="post.index" title="Jenis Energi">
    <form action="{{route('post.store')}}" method="post">
        @csrf
        <div class="form-group row">

            {{-- Nama User --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Departemen</label>
                <select class="form-control form-control-user @error('user_id') is-invalid @enderror" name="user_id">
                    <option selected disabled>Pilih Departemen</option>
                    @foreach ($user as $data)
                    <option value="{{$data->id}}">{{$data->name}}</option>
                    @endforeach
                </select>
                @error('user_id')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {{-- Nama Energi --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Jenis Energi</label>
                <select class="form-control form-control-user @error('energi_id') is-invalid @enderror"
                    name="energi_id">
                    <option selected disabled>Pilih Jenis Energi</option>
                    @foreach ($energi as $data)
                    <option value="{{$data->id}}">{{$data->nama}}</option>
                    @endforeach
                </select>
                @error('energi_id')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {{-- Nilai Energi --}}
            <x-form-input label="Nilai Energi" type="text" required="required" name="nilai_energi"></x-form-input>

            {{-- Tanggal Penggunaan --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Tanggal Penggunaan</label>
                <input type="date" class="form-control form-control-user @error('date') is-invalid @enderror" name="date">
                @error('date')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('post.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection
