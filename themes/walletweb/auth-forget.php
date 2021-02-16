<?php $v->layout("theme"); ?>

<!-- ============================================-->
<!-- <section> begin ============================-->
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <img src="<?= theme('/assets/image/forget-password.svg'); ?>" >
            </div>
            <div class="col-md-6 d-flex justify-content-center align-self-center">
                <form class="auth_form" action="<?= url("/recuperar"); ?>" data-reset="true" method="post" enctype="multipart/form-data">
                    <h1>Recuperar senha</h1>
                    <p>Informe seu e-mail para receber um link de recuperação.</p>
                    <div class="ajax_response"><?= flash(); ?></div>
                    <?= csrf_input(); ?>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="email" placeholder="Informe seu email:">
                    </div>
                    <button class="btn btn-lg btn-outline-primary btn-block" type="submit">Enviar</button>
                </form>
            </div>
    </div>
</section>

<!-- <section> close ============================-->
<!-- ============================================-->
