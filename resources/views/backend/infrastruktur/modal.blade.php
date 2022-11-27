{{-- Delete --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin Menghapus?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-dark">Jika anda yakin ingin manghapus, Tekan Oke !!</div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                    Oke
                </a>
                <form id="user-delete-form" method="POST" action="{{ route('delete_infrastruktur', 0) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="delete_id" id="delete_id">
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit--}}
<div class="modal fade" id="edit_infrastruktur" tabindex="-1" role="dialog" aria-labelledby="edit_infrastrukturExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-light" id="formModalExample"><strong>Form Edit Infrastruktur</strong>
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-dark">
                <form action="#" method="POST" id="edit_infrastruktur_sub">
                    @csrf
                    <div class="form-row">
                        <input type="text" hidden name="id" id="id">
                        <div class="row">
                            <div class="col">
                                <span>Nama Gedung</span>
                                <input type="text" name="gedung" disabled required id="gedung" class="form-control mt-2"
                                    placeholder="Gedung">
                            </div>
                            <div class="col">
                                <span>Nama Ruangan</span>
                                <input type="text" name="ruangan" disabled required id="ruangan" class="form-control mt-2"
                                    placeholder="Ruangan">
                            </div>
                        </div>
                        <div class="col  my-3">
                            <span>Nama Barang</span>
                            <input type="text" name="barang" required id="barang" class="form-control mt-2"
                                placeholder="Kuantitas">
                        </div>
                        <div class="row">
                            <div class="col">
                                <span>Kapasitas</span>
                                <input type="text" name="kapasitas" required id="kapasitas" class="form-control mt-2"
                                    placeholder="Kapasitas">
                            </div>
                            <div class="col">
                                <span>Kuantitas</span>
                                <input type="text" name="kuantitas" required id="kuantitas" class="form-control mt-2"
                                    placeholder="Kuantitas">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" id="edit_infrastruktur_btn" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>