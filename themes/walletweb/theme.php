<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Bootstrap css file -->
    <link rel="stylesheet" href="<?= theme("/assets/css/bootstrap.min.css"); ?>">
    <!-- Custom css file -->
    <link rel="stylesheet" href="<?= theme("/assets/css/style.css"); ?>">
    <title>WalletController</title>
</head>
<body>

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main">
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-4 pl-0">
        <div class="container"><a class="navbar-brand text-primary font-weight-bold" href="<?= url(); ?>"> WalletController </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item text-muted"><a class="nav-link" aria-current="page" href="<?= url(); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                </ul><a class="btn btn-primary ml-auto hover-top-shadow" href="#">Login</a>
            </div>
        </div>
    </nav>

    <!--  Dynamic content  -->
    <?= $v->section("content"); ?>
    <!--  End. Dynamic content  -->

</main>






<!-- Bootstrap js file -->
<script src="<?= theme("assets/js/jquery.3.5.1.js"); ?>"></script>
<script src="<?= theme("assets/js/bootstrap.min.js"); ?>"></script>
<script src="<?= theme("assets/js/script.js"); ?>"></script>

</body>
</html>

