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
        div {
            text-align: center;
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

    <div class="container-fluid mt-4 row">
        <form class="container row" action="{{ route('dashboardPenjualan.store') }}" method="POST">
        @csrf
        @foreach($produk as $value)

            <div class="col mt-2">
            <div class="card" style="width: 25rem;">
                <h1 class="card-title d-flex justify-content-center">{{ $value->nama_produk }}</h1>
                <div class="card-body">
                    <div>
                        <h5 class="card-title">harga : {{ $value->harga_produk }}</h5>
                        <h5 class="card-title">stok : {{ $value->stok_produk }}</h5>
                    </div>

                    <div class="qty mt-4">
                        <input type="hidden" class="form-control" id="id_produk" name="id_produk" value="{{ $value->id }}">
                        <input type="hidden" class="harga-form form-control" id="harga_produk" name="harga_produk" value="{{ $value->harga_produk }}">
                        <label class="col-form-label">TOTAL</label>
                        <input type="number" class="total-form form-control mt-2 mb-4" id="jumlah" name="jumlah" placeholder="0" readonly>
                        <span class="minus bg-dark">-</span>
                        <input type="number" class="count" name="kuantitas" id="kuantitas" placeholder="0">
                        <span class="plus bg-dark">+</span>
                    </div>
                </div>
            </div>
            </div>
        @endforeach
        <div>
            <button type="submit" class="btn btn-pill btn-primary">PESAN</button>
        </div>
    </form>
    </div>

  @endsection

  @section('scripts')

    <script>
        //
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
      
  @endsection