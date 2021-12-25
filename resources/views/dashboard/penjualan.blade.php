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
            background-color: lightcoral !important;
        }
        .plus:hover{
            background-color: lightgreen !important;
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
    <p id="TID">TID : {{ $TIDs }}</p>

    {{-- <div>
        <h2>Kategori:</h2>
    </div>

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
                            <input type="hidden" class="t_id form-control" id="t_id" name="t_id" value="{{ $TIDs }}" readonly>
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
            <a href="dashboardInvoice" class="btn btn-lg btn-pill btn-primary mt-5" >Last Invoice</a>
        </div>
        <div class="d-flex justify-content-center mt-1">
            <a href="printClosed" class="btn btn-lg btn-pill btn-danger mt-5" >Close Order</a>
        </div>
        @yield('modal') --}}

        <div class="row">
            @foreach($produk as $product)
                <div class="col-xs-18 col-sm-6 col-md-3">
                    <div class="product_box">
                        <div class="caption">
                            <h4>{{ $product->nama_produk }}</h4>
                            <p><strong>Price: </strong> {{ $product->harga_produk }}</p>
                            <p class="btn-holder"><a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <table id="cart" class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Price</th>
                    <th style="width:8%">Quantity</th>
                    <th style="width:22%" class="text-center">Subtotal</th>
                    <th style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @if(session('cart'))
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <tr data-id="{{ $id }}">
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">{{ $details['price'] }}</td>
                            <td data-th="Quantity" class="easy-get {{ $details['name'] }}">    
                                <input type="text" onClick="this.select();" value="{{ $details['quantity'] }}" class="form-control quantity update-cart easy-put"/>
                            </td>
                            <td data-th="Subtotal" class="text-center">{{ $details['price'] * $details['quantity'] }}</td>
                            <td class="actions" data-th="">
                                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right"><h3><strong>Total {{ $total }}</strong></h3></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">
                        <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                        <button class="btn btn-success">Checkout</button>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

  @endsection

  @section('scripts')
    
    <script>

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

        //plus minus counter script

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

<script type="text/javascript">
   
    $(".update-cart").change(function (e) {
        e.preventDefault();
   
        var ele = $(this);
   
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });
   
    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
   
        var ele = $(this);
   
        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
   
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
        crossorigin="anonymous">
</script>
      
  @endsection