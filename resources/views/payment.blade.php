@extends('adminlte::page')
@include('layouts.cdn')
@section('content')
<div class="container">
  @include('layouts.main_values')
    <div>
        <h2>Pagar Boleto</h2><br>
        Codigo de Barras: <input type="number" id="boleto" class="form-control" onkeyup="get_boleto()" style="width: 50%" >
    </div><hr>

    <div class="form" id="info" style="display: none">
        
    </div>
</div>

    
<script>
    function get_boleto(){
        if( $("#boleto").val().length == 13){

        }
    }
</script>
@endsection
