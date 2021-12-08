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