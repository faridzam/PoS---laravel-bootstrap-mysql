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
            background-color: darkgreen;
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
            background-color:darkred;
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
        @foreach($produk as $value)

            <div class="col mt-2">
            <div class="card" style="width: 25rem;">
                <h1 class="card-title d-flex justify-content-center">{{ $value->nama_produk }}</h1>
                <div class="card-body">
                    <div>
                        <h5 class="card-title">harga : {{ $value->harga_produk }}</h5>
                        <h5 class="card-title">stok : {{ $value->stok_produk }}</h5>
                    </div>

                <form>
                    <div class="qty mt-4">
                        <span class="minus">-</span>
                        <input type="number" class="count" name="kuantitas" id="kuantitas" value="0">
                        <span class="plus">+</span>
                    </div>
                </form>
                </div>
            </div>
            </div>
            @include('dashboard.modal.editProduk')
        @endforeach
    </div>

  @endsection

  @section('scripts')

    <script>

        		$(document).ready(function(){
		    $('.count').prop('disabled', true);
   			$(document).on('click','.plus',function(){
				$('.count').val(parseInt($('.count').val()) + 1 );
    		});
        	$(document).on('click','.minus',function(){
    			$('.count').val(parseInt($('.count').val()) - 1 );
    				if ($('.count').val() == -1) {
						$('.count').val(0);
					}
    	    	});
 		});

    </script>
      
  @endsection