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
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Historico de Boletos</button>
    </div>


    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Data de Criação</th>
                  <th>Data de Vencimento</th>
                  <th>Status</th>
                </tr>
              </thead>

              <tbody>
                @foreach($data as $value)
                  <tr>
                    <td>{{ $value->barcode }}</td>
                    <td>{{ $value->created_at }}</td>
                    <td>{{ $value->validity }}</td>
                    <td>
                      @if($value->status == 1) <div class="alert alert-success">
                      <strong>Boleto Pago</strong>
                    </div>
                      @elseif($value->status == 0) <div class="alert alert-warning">
                        <strong>Em Aberto</strong> Ou Passou da Data Limite.
                      </div>

                      @endif
                  </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
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
