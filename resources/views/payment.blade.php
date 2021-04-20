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
        var d = new Date();
        if($("#boleto").val().length == 13){
            var barcode = $("#boleto").val();
            $.ajax({
            url:"/payment_get/" + barcode,
            type: "get",
            dataType: 'json',
                success: function (response) {
                    $("#id_boleto").val(response.id);
                    $("#owner").text(response.owner);
                    $("#price").text( "R$: " + Intl.NumberFormat('en-IN', { style: 'currency', currency: 'BRL' }).format(response.value_boleto / 100));
                    $("#expiration_date").text(response.validity);
                    $("#info").css({'display': 'block'});
                }
            })
        }
    }

    function pay_boleto(){
        var id = $("#id_boleto").val();
        var d = new Date();

            $.ajax({
            url:"/payment_post/" + id,
            type: "get",
            dataType: 'json',
                success: function (response) {
                   if(response == 0){
                        swal.fire('Falha no Pagamento, Verifique se possue saldo.');
                   }
                   else if(response == 1){
                        swal.fire('Falha no Pagamento,Validade do boleto Expirada.');
                   }
                   else if(response == 2){
                        swal.fire('Boleto já Pago.');
                   }
                   else if(response == 3){
                        swal.fire('Sucesso no Pagamento.');
                   }
                   else{
                       swal.fire('Opção invalida');
                   }


                },
                
            })

    }
</script>
@endsection
