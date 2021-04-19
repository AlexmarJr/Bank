@extends('adminlte::page')
@include('layouts.cdn')
@section('content')
  <div class="container">
  @include('layouts.main_values')
       <hr>
      <div class="">
        <h2>Valor do Boleto</h2>
        <h3 style="font-size:50px">R$: <input type="text" class="dinheiro" id="value_boleto" style=" background: rgba(0, 0, 0, 0);
          border: none;
          outline: none;
          font-size:50px;" placeholder="0,00" maxlength="10"></h3>
      </div>
      <hr>
      <div class="">
        <h2>Validade do Boleto</h2><br>
        <input type="date" id="datePickerId" class="form-control" style="width: 50%" data-date-end-date="0d">
      </div>
      <hr>
      <button class="btn btn-success" onclick="post_boleto()">Gerar Boleto</button>
      <button class="btn btn-warning" onclick="post_boleto()">Historico de Boletos</button>
    </div>

    
    <script>
    datePickerId.min = new Date().toISOString().split("T")[0];
    $('.dinheiro').mask('###.000.000,00', {reverse: true});

    function post_boleto(){
       $.ajax({
           type: 'POST',
           url: "{{ route('post.boleto') }}",
           data: {
              "_token": "{{ csrf_token() }}",
               'value_boleto':  $("#value_boleto").val(),
               'validity':  $("#datePickerId").val(),
           },
           success: function(barcode) {
               swal.fire('Boleto Gerado', 'Codigo de Barras: '+ barcode, 'success');
               $('#value_boleto').val('');
               $('#datePickerId').val('');
           },
       });
    }
    </script>
@endsection
