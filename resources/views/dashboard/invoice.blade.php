@extends('dashboard.main')

@section('container')
<div>
    <h1>
        PESANAN
    </h1>
    <table id="deposit-table" name="deposit-table" class="table table-striped table-bordered nowrap" style="width:100%">
      <thead class="thead-dark">
          <tr>
              <th>nama produk</th>
              <th>harga produk</th>
              <th>kuantitas</th>
              <th>jumlah</th>
          </tr>
      </thead>
      <tbody>
          @foreach($pesananBaru as $value)
          <tr>
              <td>{{ $value->nama_produk }}</td>
              <td>{{ $value->harga_produk }}</td>
              <td>{{ $value->kuantitas }}</td>
              <td>{{ $value->jumlah }}</td>
          </tr>
          @endforeach
      </tbody>
  </table>

    <form action="{{ route('dashboardInvoice.store') }}" method="POST">
        @csrf
        <div class="qty mt-4 m-auto">
            <input type="hidden" class="form-control" id="penjualan" name="penjualan" value="{{ $pesananBaru }}">
            <label class="col-form-label">TAGIHAN</label>
            <input type="number" class="total-form form-control mt-2 mb-4" id="tagihan" name="tagihan" value="{{ $hartot }}" readonly>
            <label class="col-form-label">KEMBALIAN</label>
            <input type="number" class="form-control" id="kembalian" name="kembalian" value="0" readonly>
            <label class="col-form-label">BAYAR</label>
            <input type="number" class="form-control mt-2 mb-4" id="jumlah_bayar" name="jumlah_bayar" oninput="listen()" placeholder="0" autofocus>
        </div>
        <div>
            <button type="submit" class="btn btn-pill btn-primary">PESAN</button>
        </div>
        <div>
            <a class="btn btn-pill btn-primary" href="printInvoice">PRINT</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
        <script src="js/dashboard.js"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

        <script>

            document.getElementById("kembalian").addEventListener("#jumlah_bayar", listen);

            function listen() {
                var bayar = $('#jumlah_bayar', this.parentNode)[0];
                var tagih = $('#tagihan', this.parentNode)[0];
                var kembali = $('#kembalian', this.parentNode)[0];
                kembali.value = bayar.value - tagih.value;
            }

        </script>

@endsection