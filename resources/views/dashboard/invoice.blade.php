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
            <input type="hidden" class="form-control" id="t_id" name="t_id" value="{{ $value->t_id }}">
            <label class="col-form-label">TAGIHAN</label>
            <input type="number" class="total-form form-control mt-2 mb-4" id="tagihan" name="tagihan" value="{{ $hartot }}" readonly>
            <label class="col-form-label">KEMBALIAN</label>
            <input type="number" class="form-control" id="kembalian" name="kembalian" value="0" readonly>
            <label class="col-form-label">BAYAR</label>
            <input type="number" class="form-control mt-2 mb-4" id="jumlah_bayar" name="jumlah_bayar" oninput="listen()" placeholder="0" autofocus>
        </div>
        <div>
            <button type="submit" name="action" value="store" class="btn btn-pill btn-primary">PESAN</button>
        </div>
        <div>
            <button type="submit" name="action" value="print" class="btn btn-pill btn-primary">PRINT</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')

        <script>

            // script event listener kembalian

            document.getElementById("kembalian").addEventListener("#jumlah_bayar", listen);

            function listen() {
                var bayar = $('#jumlah_bayar', this.parentNode)[0];
                var tagih = $('#tagihan', this.parentNode)[0];
                var kembali = $('#kembalian', this.parentNode)[0];
                kembali.value = bayar.value - tagih.value;
            }

        </script>


@endsection