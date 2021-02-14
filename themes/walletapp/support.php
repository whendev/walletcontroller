<?php $v->layout("theme"); ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="ajax_response"><?= flash(); ?></div>
        <form action="<?= url("/app/suporte") ?>" method="post">
          <div class="form-group">
            <label for="exampleFormControlSelect1">Selecione o tipo de suporte:</label>
            <select name="subject" class="form-control" id="exampleFormControlSelect1">
              <option value="suporte">Preciso de suporte</option>
              <option value="sugestão">Tenho uma sugestão</option>
              <option value="reclamação">Tenho uma reclamação</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Digite sua mensagem:</label>
            <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-lg btn-primary mb-2">Enviar Email</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>





