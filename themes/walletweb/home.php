<?php $v->layout("theme"); ?>

<!-- ============================================-->
<!-- <section> begin ============================-->
<section class="py-md-5 m-lg-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 col-lg-6 order-md-1"><img class="img-fluid mb-5 mb-md-0" src="<?= theme("/assets/image/wallet.svg"); ?>" alt="" /></div>
            <div class="col-md-7 col-lg-6">
                <h1 class="display-6 text-center text-md-left">Bem vindo ao <span class="text-primary">WalletController</span>. <br />Vamos controlar suas contas?</h1>
                <p class="lead text-center text-md-left text-muted mb-3">Controle suas despesas com o melhor! controle faturas, receitas, receba avisos por email e acompanhe todos <br class="d-none d-xl-block d-xxl-none" />os detalhes pelo gráfico</p>
                <div class="text-center text-md-left pt-4">
                    <a class="btn btn-lg btn-primary hover-top-shadow mr-3 mb-2" href="<?= url("/cadastrar"); ?>">Cadastre-se
                        <svg class="bi bi-arrow-right-short" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.793 8 8.146 5.354a.5.5 0 0 1 0-.708z"></path>
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5H11a.5.5 0 0 1 0 1H4.5A.5.5 0 0 1 4 8z"></path>
                        </svg>
                    </a>
                    <a class="btn btn-lg btn-light text-primary shadow-lg hover-top-shadow mb-2" href="<?= url("/entrar"); ?>">Fazer Login</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end of .container-->
</section>
<!-- <section> close ============================-->
<!-- ============================================-->


<!-- ============================================-->
<!-- <section> begin ============================-->

<section class="py-5 mb-0  bg-light" id="about">
    <!-- Container -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 pr-lg-5 ">
                <h2>Ajudamos você a <span class="text-primary">controlar todas as suas contas</span></h2>
                <p class="text-muted mb-4">Controle suas contas de maneira rapida e simples, sem complicações! tudo disponivel de forma gratuita, crie sua conta e comece a controlar ;)</p>
                <div class="my-4">
                    <div class="d-flex mb-4 ">
                        <i class="fas fa-rocket"></i>
                        <div class="ml-3">
                            <h5>Varias funcionalidades!</h5>
                            <p class="text-muted mb-2">Nos construimos tudo que você precisa para acompanhar suas contas. Crie receitas ilimitadas, acompanhe tudo pelos graficos e muito mais!</p>
                        </div>
                    </div>
                    <div class="d-flex mb-5">
                        <i class="far fa-calendar-check"></i>
                        <div class="ml-3">
                            <h5>Saiba quando!</h5>
                            <p class="text-muted mb-4">Receba notificações quando sua fatura estiver proximo do prazo, tudo no seu email, de forma rapida e pratica clicando em um botão!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <img src="<?= theme("/assets/image/data_trends.svg"); ?>" class="img-fluid" alt="">
            </div>
        </div>
    </div>
    <!--  end of .container -->
</section>


<!-- <section> close ============================-->
<!-- ============================================-->
