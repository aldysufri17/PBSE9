@extends('backend.layouts.app')
@section('title','Edit Pengguna')
@section('content')
<x-page-form page='edit' route="user.index" title="Pengguna">
    <form action="{{route('user.update', $user->user_id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">

            {{-- Name --}}
            <x-form-input label="Nama" type="text" required="required" value="{{$user->name}}" name="name">
            </x-form-input>

            {{-- Email --}}
            <x-form-input label="Email" type="email" required="required" value="{{$user->email}}" name="email">
            </x-form-input>

            {{-- Status --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Status</label>
                <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                    <option selected disabled>Select Status</option>
                    <option value="1" {{$user->status == 1 ? 'selected' : ''}}>
                        Active</option>
                    <option value="0" {{$user->status == 0 ? 'selected' : ''}}>
                        Inactive</option>
                </select>
                @error('status')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer text-right border-0">
            <a class="btn btn-danger mr-3" href="{{ route('user.index') }}">Batal</a>
            <x-tabel-button type="submit" color="primary" title="Simpan"></x-tabel-button>
        </div>
    </form>
</x-page-form>
@endsection
