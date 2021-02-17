<?php $v->layout("theme"); ?>

<!-- ============================================-->
<!-- <section> begin ============================-->
<section class="">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="<?= theme("/assets/image/finance.svg"); ?>" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title py-2">
                        <h2 class="text-center text-primary">Login</h2>
                    </div>
                    <div class="ajax_response"><?= flash(); ?></div>
                    <form action="<?= url("/entrar"); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_input(); ?>
                        <div class="input-group py-2">
                            <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" value="<?= ($cookie ? $cookie : ""); ?>" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="far fa-user"></i></span>
                            </div>
                        </div>
                        <div class="input-group py-2">
                            <input type="password" class="form-control form-control-lg" placeholder="**********" name="password" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-6 text-center">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" <?= ($cookie ? "checked" : ""); ?> name="save"> Lembrar-se
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                <div class="forgot-password"><a href="<?= url("/recuperar"); ?>">Recuperar senha</a></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Entrar">
                                </div>
                                <div class="font-16 weight-600 pt-1 pb-1 text-center" data-color="#707373">OU</div>
                                <div class="input-group mb-0">
                                    <a class="btn btn-outline-primary btn-lg btn-block" href="<?= url("/cadastrar"); ?>">Criar conta</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- <section> close ============================-->
<!-- ============================================-->







