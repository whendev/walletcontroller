<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel de controle</title>
  <link rel="stylesheet" href="<?= theme('/plugins/fontawesome-free/css/all.min.css', CONF_VIEW_APP); ?>">
  <link rel="stylesheet" href="<?= theme('/dist/css/adminlte.min.css', CONF_VIEW_APP); ?>">

  <style>
    .hidden-input {
      display: none;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link"><span><b>ATENÇÃO!</b> Esta é uma versao BETA, algumas funcionalidades não estão disponiveis e outras estão mal feitas </span></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Sign-out -->
      <li class="nav-item ">
        <a class="nav-link" href="<?= url('/app/sair'); ?>">
          Sair <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= url('/app'); ?>" class="brand-link text-center">
      <span class="brand-text font-weight-light">WalletController</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if (user()->photo()): ?>
            <img src="<?= user()->photo(); ?>" class="img-circle elevation-2" alt="User Image">
          <?php else: ?>
            <img src="<?= theme('/assets/images/user.svg', CONF_VIEW_APP); ?>" class="img-circle elevation-2" alt="User Image">
          <?php endif; ?>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= user()->first_name ." ". user()->last_name; ?></a>
          <span class="right badge badge-success">Free</span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= url('/app') ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Controle
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= url('/app') ?>" class="nav-link disabled">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                Carteiras
                  <span class="right badge badge-info">Em breve</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= url('/app/receber') ?>" class="nav-link">
              <i class="nav-icon fas fa-calendar-plus"></i>
              <p>
                Receber
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= url('/app/pagar') ?>" class="nav-link">
              <i class="nav-icon fas fa-calendar-minus"></i>
              <p>
                Pagar
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= url('/app') ?>" class="nav-link disabled">
              <i class="nav-icon fas fa-exchange-alt"></i>
              <p>
                Fixas
                  <span class="right badge badge-info">Em breve</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= url('/app') ?>" class="nav-link disabled">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Perfil
                  <span class="right badge badge-info">Em breve</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= url('/app') ?>" class="nav-link disabled">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                Assinatura
                <span class="right badge badge-info">Em breve</span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= url('/app/suporte') ?>" class="nav-link">
              <i class="nav-icon fas fa-life-ring"></i>
              <p>
                Suporte
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= url('/app/sair') ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sair
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
      <?= $v->section('content'); ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="<?= url(); ?>">WalletController</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> BETA 1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= theme('/plugins/jquery/jquery.min.js', CONF_VIEW_APP); ?>"></script>
<!-- Bootstrap -->
<script src="<?= theme('/plugins/bootstrap/js/bootstrap.bundle.min.js', CONF_VIEW_APP); ?>"></script>
<!-- InputMask -->
<script src="<?= theme('/plugins/moment/moment.min.js', CONF_VIEW_APP); ?>"></script>
<script src="<?= theme('/plugins/inputmask/jquery.inputmask.min.js', CONF_VIEW_APP); ?>"></script>
<!-- AdminLTE -->
<script src="<?= theme('/dist/js/adminlte.js', CONF_VIEW_APP); ?>"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?= theme('/plugins/chart.js/Chart.min.js', CONF_VIEW_APP); ?>"></script>
<script src="<?= theme('/dist/js/jquery.mask.js', CONF_VIEW_APP); ?>"></script>
<?= $v->section('scripts'); ?>

<script>
  $(function () {

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('mm/yyyy', { 'placeholder': 'mm/yyyy' })

    $("#valorInputincome").inputmask('decimal', {
      'alias': 'numeric',
      'groupSeparator': '.',
      'autoGroup': true,
      'digits': 2,
      'radixPoint': ",",
      'digitsOptional': false,
      'allowMinus': false,
    });

    $("#valorInputexpense").inputmask('decimal', {
      'alias': 'numeric',
      'groupSeparator': '.',
      'autoGroup': true,
      'digits': 2,
      'radixPoint': ",",
      'digitsOptional': false,
      'allowMinus': false,
    });

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'L'
    })

  })
</script>

<script>
  $(".balance").submit(function (e) {
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
  //ajax form
  $("form:not('.ajax_off')").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var flashClass = "ajax_response";
    var flash = $("." + flashClass);
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

        //message
        if (response.message) {
          if (flash.length) {
            flash.html(response.message).fadeIn(100);
          } else {
            form.prepend("<div class='" + flashClass + "'>" + response.message + "</div>")
              .find("." + flashClass);
          }
        } else {
          flash.fadeOut(100);
        }
      },
      complete: function () {
        if (form.data("reset") === true) {
          form.trigger("reset");
        }
      }
    });
  })
</script>

<script>
  $(function () {
    /*
     * FROM CHECKBOX
     */
    $("[data-checkbox]").click(function (e) {
      let inputcheck = this;
      let inputCheckId = $(inputcheck).attr("id");
      let dataInputcheckAll = $(`[data-inputcheck]`);
      $.each(dataInputcheckAll, function (element) {
        let dataInputCheck = this;
        let dataInputCheckId = $(dataInputCheck).attr("data-inputcheck");
        if (dataInputCheckId === inputCheckId){
          $(dataInputCheck).removeClass("hidden-input")
        } else {
          $(dataInputCheck).addClass("hidden-input")
        }
      })
    });

    $(".mask-month").mask('00/0000');
  });
</script>
</body>
</html>
