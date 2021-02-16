<?php $v->layout("theme"); ?>

<!-- ============================================-->
<!-- <section> begin ============================-->
<section class="">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="<?= theme("/assets/image/savings.svg"); ?>" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title py-2">
                        <h2 class="text-center text-primary">Cadastrar</h2>
                    </div>
                    <div class="ajax_response"><?= flash(); ?></div>
                    <form action="<?= url("/cadastrar"); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_input(); ?>
                        <div class="input-group py-2">
                            <input type="text" class="form-control form-control-lg" placeholder="Primeiro nome" name="first_name" required>
                        </div>
                        <div class="input-group py-2">
                            <input type="text" class="form-control form-control-lg" placeholder="Ultimo nome" name="last_name" required>
                        </div>
                        <div class="input-group py-2">
                            <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="far fa-user"></i></span>
                            </div>
                        </div>

                        <div class="input-group py-2">
                            <input type="password" class="form-control form-control-lg" placeholder="Senha" name="password" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Criar conta">
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



