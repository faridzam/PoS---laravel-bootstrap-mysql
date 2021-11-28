    <div class="modal fade" id="exampleModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edits</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboardProduk.update', $value->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        {{-- <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" value="{{ $value->id }}">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="created_at" name="created_at" value="{{ $value->created_at }}">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="{{Carbon\Carbon::now()->format('Y-m-d')."+".Carbon\Carbon::now()->format('H:i:s')}}">
                        </div> --}}
                    <div class="form-group">
                        <label class="col-form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $value->nama_produk) }}">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Harga Produk</label>
                        <input type="number" class="form-control" id="harga_produk" name="harga_produk" value="{{ old('harga_produk', $value->harga_produk) }}">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Stok Produk</label>
                        <input type="number" class="form-control" id="stok_produk" name="stok_produk" value="{{ old('stok_produk', $value->stok_produk) }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Update</button>
                    </div>
                </form>

            </div>
            </div>
        </div>
        
    </div>