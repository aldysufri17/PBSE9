<x-alert />
<section class="section">
    <div class="section-header">
        <h1>{{$title}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
            <div class="breadcrumb-item">Daftar {{$title}}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>{{ 'Daftar '.$title }}</h4>
                @if ($routeCreate != '')
                <div class="card-header-action">
                    <div>
                        <a href="{{ route($routeCreate) }}" class="btn btn-primary create-button"
                            style="border-radius: 0px !important">
                            {{ $buttonLabel }}
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true
        });
        $(".create-button").click(function () {
            $('#loading').show();
        });
    });

</script>
@endpush
