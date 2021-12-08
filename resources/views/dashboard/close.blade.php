@extends('dashboard.main')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">

    <!-- Bootsrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <link href="/css/dashboard.css" rel="stylesheet">


    

@endsection

@section('container')
<div class="container d-flex mt-5 row justify-content-center">
    <h1> Penjualan Hari Ini </h1>
    <div class="container mt-4 d-flex row justify-content-center">
        <table id="deposit-table" name="deposit-table" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>PENJUALAN</th>
                    <th>PEMASUKAN</th>
                </tr>
            </thead>
            <tbody id="isi-tabel">
                @foreach($invoice as $value)
                    <tr class="main-tab">
                        <td class="penjualan-json" id="penjualan-json">{{ $value->penjualan }}</td>
                        <td>{{ $value->jumlah_bayar }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form action="/logout" method="post" class="d-flex justify-content-center mb-4">
        @csrf
        <button type="submit" class="btn btn-danger btn-lg d-flex">
          <i>Logout</i>
        </button>
    </form>

    <div class="container d-flex justify-content-center">
        <a href="printClose" class="btn btn-sm btn-primary" id="print-button">PRINT</a>
    </div>

</div>
@endsection

@section('scripts')

    <script>
        $('#print-button').click(function(e){
            e.preventDefault();
        var route = "{{ URL('/printClose') }}";
        var formData = {
                {{ $data }}
        });
            $.post(route, formData, function(data){
                if(data.success == 'true')
                    alert('Cetak Data Berhasil...');
                else
                    alert('Cetak Data GAGAL...');
            });
        });
    </script>

@endsection