<?php $v->layout("theme"); ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center py-3">
                <img src="<?= $image; ?>" width="450px">
            </div>
            <div class="col-12 d-flex justify-content-center py-3">
                <div class="text-center">
                    <h3 class="my-2"><?= $errorTitle; ?></h3>
                    <p class="my-2"><?= $errorDescription; ?></p>
                    <a class="btn btn-lg btn-primary  my-2" href="<?= url('/'); ?>">Voltar para pagina inicial</a>
                </div>
            </div>
        </div>
    </div>
</section>





