@extends('dashboard.main')

@section('container')
<form action="{{ route('dashboardProduk.store') }}" method="post">
    @csrf
    <h1>Tambah Produk</h1>
    <div class="form-group">
      <label for="namaP">Nama Produk</label>
      <input type="text" class="form-control" id="nama_produk" name="nama_produk" @error('nama_produk') is-invalid @enderror placeholder="Nama Produk">
      @error('nama_produk')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="hargaP">Harga Produk</label>
      <input type="number" class="form-control" id="harga_produk" name="harga_produk" @error('harga_produk') is-invalid @enderror placeholder="Harga Produk">
      @error('harga_produk')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
      @enderror
    </div>
    <div class="form-group">
        <label for="stokP">Stok Produk</label>
        <input type="number" class="form-control" id="stok_produk" name="stok_produk" @error('stok_produk') is-invalid @enderror placeholder="Stok Produk">
        @error('stok_produk')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
      @enderror
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  

  <div class="container-fluid mt-4 row">
      <h1>Produk</h1>

    @foreach($produk as $value)

        <div class="col mt-2">
        <div class="card" style="width: 25rem;">
            <h1 class="card-title d-flex justify-content-center">{{ $value->nama_produk }}</h1>
            <div class="card-body">
                <div>
                    <h5 class="card-title">harga : {{ $value->harga_produk }}</h5>
                    <h5 class="card-title">stok : {{ $value->stok_produk }}</h5>
                </div>
            
            {{-- <button href="{{ route('dashboardProduk.edit', $value->id) }}" class="btn btn-primary">edit produk</button> --}}
            <button type="button" href="{{ route('dashboardProduk.edit', $value->id) }}" class="btn btn-primary editbtn d-inline" data-toggle="modal" data-target="#exampleModal{{ $value->id }}">edit</button>
            
            <form action="{{ route('dashboardProduk.destroy', $value->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn bg-danger btn-primary border-0" onclick="return confirm('menghapus produk {{ $value->nama_produk }}?')">hapus produk</button>
            </form>
            </div>
        </div>
        </div>
        @include('dashboard.modal.editProduk')
    @endforeach

  </div>

@endsection

@section('scripts')

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

@endsection