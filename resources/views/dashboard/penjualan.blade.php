@extends('dashboard.main')

@section('styles')
    <style>
                .qty .count {
            color: #000;
            display: inline-block;
            vertical-align: top;
            font-size: 25px;
            font-weight: 700;
            line-height: 30px;
            padding: 0 2px;
            width: 100px;
            text-align: center;
        }
        .qty .plus {
            cursor: pointer;
            display: inline-block;
            vertical-align: top;
            color: white;
            width: 30px;
            height: 30px;
            font: 30px/1 Arial,sans-serif;
            text-align: center;
            border-radius: 50%;
            }
        .qty .minus {
            cursor: pointer;
            display: inline-block;
            vertical-align: top;
            color: white;
            width: 30px;
            height: 30px;
            font: 30px/1 Arial,sans-serif;
            text-align: center;
            border-radius: 50%;
            background-clip: padding-box;
        }
        .minus:hover{
            background-color: red !important;
        }
        .plus:hover{
            background-color: green !important;
        }
        /*Prevent text selection*/
        span{
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        input{  
            border: 0;
            width: 2%;
        }
        nput::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input:disabled{
            background-color:white;
        }
                
    </style>
@endsection

@section('container')
    
    <h1>Penjualan</h1>

    <div class="container-fluid d-flex justify-content-center mt-4 row">
        @foreach($produk as $value)

            <div class="col mt-2">
            <div class="card" style="width: 20rem;">
                <h1 class="card-title d-flex justify-content-center">{{ $value->nama_produk }}</h1>
                <div class="card-body">
                    <div>
                        <h5 class="card-title d-flex justify-content-center">harga : {{ $value->harga_produk }}</h5>
                    </div>
                    <form class="d-flex justify-content-center" action="{{ route('dashboardPenjualan.store') }}" method="POST">
                    @csrf
                        <div class="qty mt-4 m-auto">
                            <input type="hidden" class="form-control" id="id_produk" name="id_produk" value="{{ $value->id }}">
                            <input type="hidden" class="form-control" id="nama_produk" name="nama_produk" value="{{ $value->nama_produk }}">
                            <input type="hidden" class="harga-form form-control" id="harga_produk" name="harga_produk" value="{{ $value->harga_produk }}">
                            <label class="col-form-label d-flex justify-content-center">TOTAL</label>
                            <input type="number" class="total-form form-control mt-2 mb-4" id="jumlah" name="jumlah" placeholder="0" readonly>
                            <span class="minus bg-dark ml-5">-</span>
                            <input type="number" class="count m-auto" name="kuantitas" id="kuantitas" placeholder="0">
                            <span class="plus bg-dark m-auto">+</span>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center mt-5">
            <button class="btn btn-lg btn-pill btn-primary mt-5" id="sub">PESAN</button>
        </div>
        <div class="d-flex justify-content-center mt-1">
            <a href="{{ route('dashboardInvoice.create') }}" class="btn btn-lg btn-pill btn-danger mt-5" >Close Order</a>
        </div>
        @yield('modal')
    </div>

  @endsection

  @section('scripts')

    <script>
        //
        submitForms = function() {
            $("form").each(function(){
                $.ajax({
                    url:"{{ route('dashboardPenjualan.index') }}",
                    method:'POST',
                    data: $(this).serialize(),
                    success: function(r){
                        //...
                        window.location.href = "{{ route('dashboardInvoice.index') }}"
                    }
                });
             });
         }
    </script>

    <script>
        $("#sub").click(function(){
            $("form").each(function(){
                var fd = new FormData($(this)[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboardPenjualan.index') }}",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(data,status) {
                    //this will execute when form is submited without errors
                    window.location.href = "{{ route('dashboardInvoice.index') }}"
                },
                error: function(data, status) {
                    //this will execute when get any error
                },
            });
            });
        });

    </script>

    <script>

        // if user changes value in field
        //$('.').change(function() {
        // maybe update the total here?
        //}).trigger('change');


        $('.plus').click(function() {
        var target = $('.count', this.parentNode)[0];
        var tot = $('.total-form', this.parentNode)[0];
        var har = $('.harga-form', this.parentNode)[0];
        target.value = +target.value + 1;
        tot.value = target.value * har.value;
        });

        $('.minus').click(function() {
        var target = $('.count', this.parentNode)[0];
        var tot = $('.total-form', this.parentNode)[0];
        var har = $('.harga-form', this.parentNode)[0];
        if (target.value > 0) {
            target.value = +target.value - 1;
            tot.value = target.value * har.value;
        }
        });
        

    </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
        <script src="js/dashboard.js"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

      
  @endsection