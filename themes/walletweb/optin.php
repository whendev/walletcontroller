<?php $v->layout("theme"); ?>



<!-- ============================================-->
<!-- <section> begin ============================-->
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="text-center">
                <h1 class="my-5" ><?= $data->title; ?></h1>
                <h3 class="my-4 " ><?= $data->desc; ?></h3>
                <img class="my-4" src="<?= $data->image; ?>" height="150" width="150">
                <?php if (!empty($data->link)): ?>
                    <div>
                        <a class="btn btn-outline-primary" href="<?= $data->link; ?>"><?= $data->linkTitle; ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>





<!-- <section> close ============================-->
<!-- ============================================-->

