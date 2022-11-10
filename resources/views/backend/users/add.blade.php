@extends('backend.layouts.app')
@section('title','Tambah Pengguna')
@section('content')
<x-page-form page='create' route="user.index" title="Pengguna">
    <form action="{{route('user.store')}}" method="post">
        @csrf
        <div class="form-group row">

            {{-- Name --}}
            <x-form-input label="Nama" type="text" required="required" name="name"></x-form-input>

            {{-- Email --}}
            <x-form-input label="Email" type="email" required="required" name="email"></x-form-input>

            {{-- Status --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Status</label>
                <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                    <option selected disabled>Pilih Status</option>
                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {{-- Role --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                <span style="color:red;">*</span>Role</label>
                <select id="role" class="form-control form-control-user @error('role') is-invalid @enderror" name="role">
                    <option selected disabled>Pilih Role</option>
                    <option value="128" {{ old('role') == 128 ? 'selected' : '' }}>Admin</option>
                    <option value="4" {{ old('role') == 4 ? 'selected' : '' }}>Auditor</option>
                    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Pengguna</option>
                </select>
                @error('role')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {{-- Section --}}
            <div class="col-sm-6 mb-3 mt-3 mb-sm-0" id="section">
                <span style="color:red;">*</span>Departemen</label>
                <select class="form-control form-control-user @error('section') is-invalid @enderror" name="section">
                    <option selected disabled>Pilih Departemen</option>
                    @foreach ($section as $item)
                    <option value="{{$item->section_id}}" {{ old('section',$item->section_id) == $item->section_id ? 'selected' : '' }}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('section')
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

@push('scripts')
<script>
    $('#section').hide();
    $(document).on('change', '#role', function () {
        var select = $('#role option:selected').val()
        if (select != 128) {
            $('#section').show();
        }else{
            $('#section').hide();
        }
    })
</script>
@endpush