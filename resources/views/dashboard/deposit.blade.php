@extends('dashboard.main')

@section('container')
<form action="/dashboardDeposit" method="POST">
    @csrf
    <div class="mb-3">
      <label for="deposit-header" class="form-label">Nilai Deposit</label>
      <input type="number" class="form-control" id="nominal" name="nominal" autofocus>
      <div id="deposit-helper" class="form-text">masukan jumlah modal awal sebelum penjualan.</div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div class="container mt-5">
    <div class="container-fluid">
        <table id="deposit-table" name="deposit-table" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>deposit id</th>
                    <th>admin id</th>
                    <th>nominal</th>
                    <th>tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->admin }}</td>
                    <td>{{ $value->nominal }}</td>
                    <td>{{ $value->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <a href="printDeposit" class="btn btn-sm btn-primary" id="print-button">PRINT</a>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="js/dashboard.js"></script>

{{-- js --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

<script>

    $(document).ready(function()
    {
        $('#deposit-table').DataTable( {
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            var data = row.data();
                            return 'Details for '+data[0]+' '+data[1];
                        }
                    } ),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                        tableClass: 'table'
                    } )
                }
            }
        } );
    } );
</script>

<script>
    $('#print-button').click(function(e){
    	e.preventDefault();
	var route = "{{ URL('/printDeposit') }}";
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