@extends('adminlte::page')
@include('layouts.cdn')

@section('content')
    <div class="container">
       @include('layouts.main_values')
       <hr>

       <div class="row">
        <div class="col-2">
        </div>
            <div class="col-4">
                <div class="card" style="width: 14rem;">
                    <img class="card-img-top" src="{{ asset('img/pix_icon.png') }}" alt="Card image cap" height="200" >
                    <div class="card-body">
                      <h5 class="card-title">Transferencia Via PIX</h5>
                      <p class="card-text"></p>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pixModal">
                        Faz o PIX Menor
                      </button>
                    </div>
                  </div>
            </div>

            <div class="col-4">
                <div class="card" style="width: 14rem;">
                    <img class="card-img-top" src="{{ asset('img/ted.png') }}" alt="Card image cap" height="200">
                    <div class="card-body">
                      <h5 class="card-title">Tranferencia via TED</h5>
                      <p class="card-text">kkkk Quem é que faz TED?</p>
                      <button type="button" class="btn btn-primary" onclick="alert_ted()">
                        Fazer TED
                      </button>
                    </div>
                  </div>
            </div>
            <div class="col-2">
            </div>
       </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="pixModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Transferencia via PIX</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="id_user" value="">
          <div class="row">
            <div class="col-6">
                <label for="">Tipo: </label>
                <select name="type" id="type" class="form-control">
                    <option value="">Tipo</option>
                    <option value="cpf">CPF/CNPJ</option>
                    <option value="phone">Telefone</option>
                    <option value="email">Email</option>
                    <option value="random">Aleatoria</option>
                </select>
            </div>
            <div class="col-6">
                <label for="">Chave</label>
                <input type="text" class="form-control" id="key">
            </div>
          </div>
          <hr>

          <div class="" style="margin: auto;width: 60%;padding: 10px;display:none" id="value_pix">
             <h2 style="text-align: center">Valor</h2>
             <h3 style="font-size:40px">R$: <input type="text" class="dinheiro" id="pix" style=" background: rgba(0, 0, 0, 0);
               border: none;
               outline: none;
               width: 70%;
               font-size:40px;" placeholder="0,00" maxlength="10"></h3>
            <hr>
          </div>
            <div id="info_pix" style="display: none">
                <h4 style="text-align: center">Informações do Beneficiario</h4>
                    <br>
                <div class="row" >
                    <div class="col-12">
                        <label for="">Nome: <span id="name_pix"></span></label>
                    </div>
                    <div class="col-6">
                        <label for="">CPF:  <span id="cpf_pix"></span></label>
                    </div>
                    <div class="col-6">
                        <label for="">Conta:  <span id="account_pix"></span></label>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" onclick="search_pix()" id="search_btn">Buscar</button>
          <button type="button" class="btn btn-primary" style="display: none;" id="post_btn" onclick="post_pix()">Enviar</button>
        </div>
      </div>
    </div>
  </div>


<script> 
    $('.dinheiro').mask('###.000.000,00', {reverse: true});

function search_pix(){

    if($("#type").val() == '' || $("#key").val() == ''){
        swal.fire('Tipo da chave e chave são obrigatorias');
    }
    else{
        var type = $("#type").val();
        var key = $("#key").val();
        
        $.ajax({
            url:"/pix_get/" + type + '/' + key,
            type: "get",
            dataType: 'json',
                success: function (response) {
                    if(response == 0){
                        swal.fire("Chave não encontrada");
                        return 0;
                    }
                    $("#id_user").val(response[0].id);
                    $("#name_pix").text(response[0].name);
                    $("#cpf_pix").text(response[0].cpf);
                    $("#account_pix").text(response[0].account);
                    $("#info_pix").css({'display':'block'});
                    $("#value_pix").css({'display':'block'});
                    $("#search_btn").css({'display':'none'});
                    $("#post_btn").css({'display':'block'});
                }
            })
        }
}

function post_pix(){
    if($("#pix").val() <= 0){
        swal.fire('Valor nao pode ser 0');
    }else{
        $.ajax({
           type: 'POST',
           url: "{{ route('post_pix') }}",
           data: {
              "_token": "{{ csrf_token() }}",
               'id':  $("#id_user").val(),
               'pix_value': parseInt(($("#pix").val().replace(',','').replace('.',''))),
           },
           success: function(response) {
               if(response == 1){
                swal.fire('Voce não tem Saldo suficiente');
                $("#pixModal").modal('hide');
                return 0;
               }
               swal.fire('Transferencia bem sucessida');

           },
       });
    }
    
}

function alert_ted(){
    swal.fire("Deu preguiça de fazer esse aqui, mas é a mesma coisa do pix mas usando o 'Account' do usuario");
}

</script>
@endsection
