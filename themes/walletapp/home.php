<?php $v->layout('theme'); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col d-flex">
        <h1 class="m-0"><?= $localPage; ?></h1>
        <a class="btn btn-outline-dark btn-lg ml-auto" data-toggle="dropdown" href="#">
          <i class="fas fa-toolbox"></i> Minhas carteiras
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Suas Carteiras</span>
          <div class="dropdown-divider"></div>

          <?php foreach ($wallets as $walletItem): ?>
            <a href="#" class="dropdown-item">
              <i class="fas fa-toolbox"></i> <?= $walletItem->wallet; ?>
            </a>
          <?php endforeach; ?>
        </div>

      </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="d-block ajax_response"><?= flash(); ?></div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Grafico -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <i class="fas fa-chart-bar"></i>
              <h3 class="card-title">Controle</h3>
            </div>
          </div>
          <div class="card-body">

            <div class="position-relative mb-4">
              <canvas id="myChart" height="100px"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Receitas
                  </span>

              <span>
                    <i class="fas fa-square text-danger"></i> Despesas
                  </span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card card-outline card-success">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <i class="fas fa-calendar-plus"></i>
                  <h3 class="card-title">À receber</h3>
                </div>
              </div>
              <div class="card-body">

                <?php if (!empty($income)): ?>
                  <?php foreach ($income as $incomeItem): ?>
                    <?= $v->insert("views/balance", ["invoice" => $incomeItem]); ?>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-md"> No momento, não existem contas a receber.</span>
                    </p>
                  </div>
                <?php endif; ?>

              </div>
              <div class="card-footer">
              </div>
            </div>
            <!-- /.card -->
          </div>

          <div class="col-lg-6">
            <div class="card card-outline card-danger">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <i class="fas fa-calendar-minus"></i>
                  <h3 class="card-title">À pagar</h3>
                </div>
              </div>
              <div class="card-body">
                <?php if (!empty($expense)): ?>
                  <?php foreach ($expense as $expenseItem): ?>
                    <?= $v->insert("views/balance", ["invoice" => $expenseItem]); ?>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-md"> No momento, não existem contas a pagar.</span>
                    </p>
                  </div>
                <?php endif; ?>
              </div>
              <div class="card-footer">
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
      <!-- Grafico -->

      <!-- /.col-md-4 -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <button type="button" data-toggle="modal" data-target="#income" class="btn btn-outline-success btn-lg"><i class="fa fa-plus-circle"></i> Receita</button>
              <button type="button" data-toggle="modal" data-target="#expense" class="btn btn-outline-danger btn-lg"><i class="fa fa-plus-circle"></i> Despesa</button>
            </div>
            <div class="modals">
              <!-- Modal -->
              <?= $v->insert("views/modals", []); ?>

            </div>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-center">
              <p class="d-flex flex-column text-center">
                <span class="saldo text-bold text-lg">R$ <?= str_price(($wallet->wallet ?? "0.0")); ?></span>
                <span>Saldo atual</span>
              </p>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>

<?php $v->start('scripts'); ?>
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',
    // The data for our dataset
    data: {
      // labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      labels: [<?= $chartData->categories; ?>],
      datasets: [{
        label: 'Receitas',
        backgroundColor: 'rgba(0,94,255,0.2)',
        borderColor: 'rgb(0,94,255)',
        data: [<?= $chartData->income; ?>]
      },
      {
        label: 'Despesas',
        backgroundColor: 'rgba(255, 99, 132,0.2)',
        borderColor: 'rgb(255, 99, 132)',
        data: [<?= $chartData->expense; ?>]
      }]
    },

    // Configuration options go here
    options: {
      tooltips: {
        mode: 'point'
      },
      legend: {
        display: false
      }
    }
  });

  // dash
  $(".dash").submit(function (e) {
      e.preventDefault();
      var form = $(this);
      var balanceStatus = "balance_status";
      var dados = form.serialize();

      $.ajax({
          url: form.attr("action"),
          data: dados,
          type: "POST",
          dataType: "json",
          beforeSend: function () {
          },
          success: function (response) {
              //redirect
              if (response.redirect) {
                  window.location.href = response.redirect;
              }

              if (response.chart){
                  chart.data.labels = response.chart.labels;
                  chart.data.datasets[0].data = response.chart.income;
                  chart.data.datasets[1].data = response.chart.expense;
                  chart.update();
                  var saldo = $('.saldo');
                  saldo.html("");
                  saldo.prepend("<span class='saldo text-bold text-lg'>R$"+ response.chart.wallet +"</span>")

              }

              //message
              if (response.status) {
                  if (response.status === "paid") {
                      form.html("").find("." + balanceStatus)
                      form.prepend("<input type='hidden' name='user_id' value='" + response.user + "'>" + "<input type='hidden' name='id' value='" + response.id + "'>" + "<input type='hidden' name='status' value='"+ response.status +"'>" + "<button class='btn p-0' type='submit'><span class='badge bg-success'>Pago<i class='fas fa-exchange-alt pl-2'></i></span></button>")
                          .find("." + balanceStatus);
                  } else {
                      form.html("").find("." + balanceStatus)
                      form.prepend("<input type='hidden' name='user_id' value='" + response.user + "'>" + "<input type='hidden' name='id' value='" + response.id + "'>" + "<input type='hidden' name='status' value='"+ response.status +"'>" + "<button class='btn p-0' type='submit'><span class='badge bg-danger'>Não Pago<i class='fas fa-exchange-alt pl-2'></i></span></button>")
                          .find("." + balanceStatus);
                  }
              }
          },
      });
  })
</script>
<?php $v->stop(); ?>
