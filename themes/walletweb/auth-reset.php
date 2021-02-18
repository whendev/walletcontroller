<?php $v->layout("theme"); ?>


<!-- ============================================-->
<!-- <section> begin ============================-->

<section class="m-lg-0">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center">
                <img src="<?= theme("/assets/image/reset-password.svg");?>" width="350px">
            </div>

            <div class="col-md-6 d-flex justify-content-center align-self-center">
                <form action="<?= url("/recuperar/resetar"); ?>" method="post">
                    <div class="py-2">
                        <h2 class="text-center text-primary">Recuperar senha</h2>
                    </div>
                    <div class="ajax_response"><?= flash(); ?></div>
                    <?= csrf_input(); ?>
                    <input type="hidden" name="code" value="<?= $code; ?>">
                    <div class="form-group">
                        <label for="password">Digite sua nova senha:</label>
                        <input class="form-control form-control-lg" type="password" name="password" required id="password" placeholder="***********">
                    </div>
                    <div class="form-group">
                        <label for="password">Repita sua nova senha:</label>
                        <input class="form-control form-control-lg" type="password" name="password_re" required id="password" placeholder="***********">
                    </div>
                    <button type="submit" class="btn btn-lg btn-outline-primary">Recuperar</button>
                </form>
            </div>
        </div>
    </div>
</section>



<!-- <section> close ============================-->
<!-- ============================================-->