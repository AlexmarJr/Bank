@extends('adminlte::page')
@include('layouts.cdn')

@section('content')
    <div class="container">
       @include('layouts.main_values')
       <hr>

       <div class="" style="margin: auto;width: 40%;padding: 10px;">
        <h2 style="">Realizar Saque</h2>
             <h3 style="font-size:40px">R$: <input type="text" class="dinheiro" id="pix" style=" background: rgba(0, 0, 0, 0);
               border: none;
               outline: none;
               width: 70%;
               font-size:40px;" placeholder="0,00" maxlength="10"></h3>
<hr>
               <button class="btn btn-success" onclick="withdraw()">Sacar</button>
       </div>
    </div>

<script>
    $('.dinheiro').mask('###.000.000,00', {reverse: true});

    function withdraw(){
        if($("#pix").val() == ''){
            swal.fire('Não da pra sacar 0 Reais.');
            return 0;
        }
        var value = parseInt(($("#pix").val().replace(',','').replace('.','')));
        $.ajax({
            url:"/withdraw/" + value,
            type: "get",
            dataType: 'json',
                success: function (response) {
                    if(response == 0){
                        swal.fire("Você não tem saldo suficiente.");
                        return 0;
                    }
                    else{
                        swal.fire('Saque Realizado');
                    }
                   
                }
            })
    }
</script>
@endsection
