<div class="col-sm-6 mb-3 mt-3 mb-sm-0">
    <span style="color:red;">{{ $required ? '*' : '' }}</span>{{$label}}</label>
    <input autocomplete="off" type="text" type="{{ $type }}" name="{{ $name }}" value="{{ $value ?? old($name) }}"
        class="form-control form-control-user @error('{{$name}}') is-invalid @enderror" id="exampleName"
        placeholder="{{$label}}" {{ $required ?? '' }} {{ $disabled }}>

    @error('{{$name}}')
    <span class="text-danger">{{$message}}</span>
    @enderror
</div>
