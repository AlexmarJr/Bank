@extends('adminlte::page')
@include('layouts.cdn')
@section('content')
<div class="container">
  @include('layouts.main_values')
    <div>
        <h2>Pagar Boleto</h2><br>
        Codigo de Barras: <input type="number" id="boleto" class="form-control" onkeyup="get_boleto()" style="width: 50%" >
    </div><hr>

    <div id="info" style="display: none; ">
        <input type="hidden" id="id_boleto" value="">
        <h5 >Beneficiario: <p id="owner"></p></h5>
        <h5>Valor: <p id="price"></p></h5>
        <h5>Data Limite: <p id="expiration_date"></p></h5>

        <button class="btn btn-success" onclick="pay_boleto()">Pagar Boleto</button>
    </div>
</div>

    
<script>
    function get_boleto(){
        if($("#boleto").val().length == 13){
            var barcode = $("#boleto").val();
            $.ajax({
            url:"/payment_get/" + barcode,
            type: "get",
            dataType: 'json',
                success: function (response) {
                    $("#id_boleto").val(response.id);
                    $("#owner").text(response.owner);
                    $("#price").text( "R$: " + response.value_boleto);
                    $("#expiration_date").text(response.validity);
                    $("#info").css({'display': 'block'});
                }
            })
        }
    }

    function pay_boleto(){
        var id = $("#id_boleto").val();
        var d = new Date();

        if($("#expiration_date").val() < d){
            swal.fire({ 
                icon: 'error',
                title: 'Falha no Pagamento',
                text: 'Esse Boleto ja se expirou',
            });
        }


    }
</script>
@endsection
