@extends('adminlte::page')
@include('layouts.cdn')

@section('content')
    <div class="container">
       @include('layouts.main_values')
       <hr>
       <div class="row">
        <div class="col-3">
            <div class="card" style="width: 14rem;">
                <img class="card-img-top" src="{{ asset('img/cdi.png') }}" alt="Card image cap" height="200" >
                <div class="card-body">
                  <h5 class="card-title">Invista em CDB</h5>
                  <p class="card-text"></p>
                  <button type="button" class="btn btn-primary" onclick="open_modal('0')">
                    Invista
                  </button>
                </div>
              </div>
        </div>
            <div class="col-3">
                <div class="card" style="width: 14rem;">
                    <img class="card-img-top" src="{{ asset('img/cdb.jpg') }}" alt="Card image cap" height="200" >
                    <div class="card-body">
                      <h5 class="card-title">Invista em CDI</h5>
                      <p class="card-text"></p>
                      <button type="button" class="btn btn-primary" onclick="open_modal('1')">
                        Invista
                      </button>
                    </div>
                  </div>
            </div>

            <div class="col-3">
                <div class="card" style="width: 14rem;">
                    <img class="card-img-top" src="{{ asset('img/lci.png') }}" alt="Card image cap" height="200">
                    <div class="card-body">
                      <h5 class="card-title">Invista em LCI</h5>
                      <p class="card-text"></p>
                      <button type="button" class="btn btn-primary" onclick="open_modal('2')">
                        Invista
                      </button>
                    </div>
                  </div>
            </div>
            <div class="col-3">
                <div class="card" style="width: 14rem;">
                    <img class="card-img-top" src="{{ asset('img/poupanca.png') }}" alt="Card image cap" height="200" >
                    <div class="card-body">
                      <h5 class="card-title">Invista em Poupança</h5>
                      <p class="card-text"></p>
                      <button type="button" class="btn btn-primary" onclick="open_modal('3')">
                        Invista
                      </button>
                    </div>
                  </div>
            </div>
       </div>
    </div>


    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Invista em <b id="investment"></b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="" style="margin: auto;width: 60%;padding: 10px;">
                <h2 style="text-align: center">Valor</h2>
                <h3 style="font-size:40px">R$: <input type="text" class="dinheiro" id="invest" style=" background: rgba(0, 0, 0, 0);
                  border: none;
                  outline: none;
                  width: 70%;
                  font-size:40px;" placeholder="0,00" maxlength="10"></h3>
             </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" onclick="investment_post()">Investir</button>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    $('.dinheiro').mask('###.000.000,00', {reverse: true});

    function open_modal(inv){
        if(inv == 0){
            $("#investment").text("CDB");
        }
        else if(inv == 1){
            $("#investment").text("CDI");
        }
        else if(inv == 2){
            $("#investment").text("LCI");
        }
        else if(inv == 3){
            $("#investment").text("Poupança");
        }

        $("#exampleModal").modal('show');
    }

    function investment_post(){
        if($("#invest").val() == ''){
        swal.fire('Não da pra investir 0 Reais!');
    }
    else{
        var value = parseInt(($("#invest").val().replace(',','').replace('.','')));
        
        $.ajax({
            url:"/investments/" + value,
            type: "get",
            dataType: 'json',
                success: function (response) {
                    if(response == 0){
                        swal.fire("Voçê não possui saldo");
                        return 0;
                    }
                    swal.fire(Intl.NumberFormat('en-IN', { style: 'currency', currency: 'BRL' }).format(response / 100) + ' Reais investidos');
                }
            })
        }
    }
  </script>
@endsection
