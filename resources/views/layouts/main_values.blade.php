<div class="row">
    <div class="col-6">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Valor na Conta</span>
              <span class="info-box-number">R$: {{number_format((int)Auth::user()->balance / 100, 2, ',', '.') }} <button class="btn btn-primary" onclick="add_found()">+ 1000 R$</button></span> 
              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
              <span class="progress-description">
                Isso aqui não ta funcionando, e nem vai, mo trabalho
              </span>
            </div>
          </div>
    </div>
    <div class="col-6">
        <div class="info-box bg-gradient-warning">
            <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Valor Investido</span>
              <span class="info-box-number">{{number_format((int)Auth::user()->stocks / 100, 2, ',', '.') }} <button class="btn btn-primary" onclick="withdraw_found()">Retirar Investimentos</button></span>
              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                <span class="progress-description">
                  70% Aumento.. Ou deveria ser.
                </span>
              </div>
            </div>
          </div>
    </div>
</div>

<script>
  function add_found(){
    $.ajax({
                url:"/add_founds",
                type: "get",
                dataType: 'json',
            success: function (response) {
               swal.fire('Atualiza a pagina ai que o valor la não ta ajax não :(')
            }
        })  
  }

  function withdraw_found(){
    $.ajax({
                url:"/withdraw_founds",
                type: "get",
                dataType: 'json',
            success: function (response) {
               swal.fire('Retirada completa. Atualiza a pagina ai que o valor la não ta ajax não :(')
            }
        })  
  }
</script>