<div>
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{route($route)}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
                <h1>{{$title}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{route($route)}}">{{'Daftar '. $title}}</a></div>
                <div class="breadcrumb-item">{{ $page == 'create' ? 'Tambah' : 'Ubah' }} {{$title}}</div>
            </div>
        </div>
    
        <div class="section-body">
            <div class="card">
                <div class="card-header pb-0">
                    <h4>Form {{$page == 'create' ? 'Tambah ' : 'Ubah ' . $title}}</h4>
                </div>
    
                <div class="card-body pt-0">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </section>
</div>