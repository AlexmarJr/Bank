@extends('adminlte::page')
@include('layouts.cdn')
@section('content')
    <div class="container">
       @include('layouts.main_values')
       
       <div>
           <h3>Nome: <b> {{ Auth::user()->name }} </b></h3>
           <h3>CPF:  <b>{{ Auth::user()->cpf }}</b></h3>
           <h3>Conta:  <b>{{ Auth::user()->account }}</b></h3>
           <hr>
           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Configurar PIX
            </button>
          
       </div>
    </div>


    <!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Chaves Pix</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h4>Adicionar Chave</h4>
            <div class="row">
                <div class="col-3">
                    <label for="">Tipo: </label>
                    <select name="type" id="type" class="form-control" onchange="check_type()">
                        <option value="">Tipo</option>
                        <option value="cpf">CPF/CNPJ</option>
                        <option value="phone">Telefone</option>
                        <option value="email">Email</option>
                        <option value="random">Aleatoria</option>
                    </select>
                </div>
                <div class="col-6" id="key_form">
                    <label for="">Chave</label>
                    <input type="text" class="form-control" id="key" onkeyup="check_type()">
                </div>
                <div class="col-3">
                    <label for="">Principal?</label>

                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1"></label>
                      </div>
                </div>
            </div>
            
            <hr>
            <h4>Chaves Ativas</h4>
          <table id="pix_table" class="table">
              <thead>
                  <tr>
                      <th>Tipo</th>
                      <th>Chave</th>
                      <th>Principal</th>
                      <th>Ação</th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" onclick="save_pix()" id="btn_save" disabled>Salvar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
      function getRecords() {
        
        $.ajax({
            url: "{{ route('get_pix') }}",
            type: "get",
            dataType: 'json',
            success: function (data) {
                var s = '';
                var html='';
                data.forEach(function(row){
                    html += '<tr>'
                    html += '<td>' + row.type + '</td>'
                    html += '<td>' + row.key + '</td>'
                    
                    if(row.principal == 1){
                        html += '<td style="color: green; padding-left: 25px"><i class="fas fa-check-circle"></i></td>'
                    }else{
                        html += '<td>'
                        html += '<button style="color: red" class="btn principal" data-id="' + row.key + '" title="Tornar Principal" ><i class="fas fa-check-circle"></i></button> &nbsp &nbsp'
                        html += '</td>'
                    }
                   
                    html += '<td>'
                    html += '<button  class="btn delete" data-id="' + row.key + '" title="Detele PIX" ><i class="fas fa-trash"></i></button> &nbsp &nbsp'
                    html += '</td> </tr>';
                })
                    $('table tbody').html(html);
                
                }
        })
    }

    getRecords();

    function save_pix(){
        if($("#customSwitch1").is(':checked') == true){
            switch_form = 1;
        }
        else{
            switch_form = 0;
        }

        $.ajax({
           type: 'POST',
           url: "{{ route('post.pix') }}",
           data: {
              "_token": "{{ csrf_token() }}",
               'type':  $("#type").val(),
               'key':  $("#key").val(),
               'principal':  switch_form,
           },
           success: function() {
               getRecords();
               swal.fire('PIX Salvo', 'success');
               $('#type').val('');
               $('#key').val('');
               $("#customSwitch1" ).prop( "checked", false );
           },
       });
    }

    $('table').on('click', '.delete', function () {
        var id = $(this).data('id');
        $.ajax({
                url:"/delete_pix/" + id,
                type: "get",
                dataType: 'json',
            success: function (response) {
                getRecords();
            }
        })  
    }) 

    $('table').on('click', '.principal', function () {
        var key = $(this).data('id');
        $.ajax({
                url:"/change_principal/" + key,
                type: "get",
                dataType: 'json',
            success: function (response) {
            getRecords();
            }
        })  
    }) 

    function check_type(){

        if($('#type').val() == '' || $('#key').val() == ''){
            $('#type').css(({'border-color':'red', 'border-style':'solid'}));
            $('#key').css(({'border-color':'red', 'border-style':'solid'}));
            $("#btn_save").prop("disabled",true);
        }
        else{
            $('#type').css(({'border-color':'black', 'border-style':''}));
            $('#key').css(({'border-color':'black', 'border-style':''}));
            $("#btn_save").prop("disabled",false);
        }

        if($('#type').val() == 'random'){
            $('#type').css(({'border-color':'black', 'border-style':''}));
            $("#key_form").css({'display':'none'});
            $("#btn_save").prop("disabled",false);
        }
        else{
            $("#key_form").css({'display':'block'});
        }

    }
    check_type();
  </script>
@endsection
