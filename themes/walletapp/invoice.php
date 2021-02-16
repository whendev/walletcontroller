<?php $v->layout("theme"); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col">
        <div class="card">
          <div class="card-header">
          </div>
          <div class="card-body">
            <form action="<?= url("app/invoice"); ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?= $invoice->id; ?>">
              <input type="hidden" name="type" value="<?= $invoice->type; ?>">
              <input type="hidden" name="alter" value="update">
              <div class="modal-body">
                <div class="form-group">
                  <label for="descriptionInput<?= $invoice->type; ?>">Descrição:</label>
                  <input id="descriptionInput<?= $invoice->type; ?>" type="text" name="description" class="form-control" placeholder="Ex: Aluguel..." value="<?= $invoice->description; ?>">
                </div>

                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label for="valorInput<?= $invoice->type; ?>">Valor:</label>
                    <input id="valorInput<?= $invoice->type; ?>" type="text" class="form-control" name="value" placeholder="0,00" maxlength="22" value="<?= str_replace(".", ",",$invoice->value); ?>">
                  </div>

                  <div class="form-group col-sm-6">
                    <label for="dateInput<?= $invoice->type; ?>">Data:</label>
                    <input class="form-control" name="due_at" type="date" value="<?= $invoice->due_at; ?>" id="dateInput<?= $invoice->type; ?>">
                  </div>
                </div>


                <div class="form-group">
                  <label for="WalletInput<?= $invoice->type; ?>">Carteira:</label>
                  <select id="WalletInput<?= $invoice->type; ?>" name="wallet_id" class="form-control">
                    <?php foreach ($wallets as $wallet): ?>
                      <option value="<?= $wallet->id; ?>" <?= ($wallet->id == $invoice->wallet_id ? "selected" : ""); ?>><?= $wallet->wallet; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="categoriesInput<?= $invoice->type; ?>">Categoria:</label>
                  <select id="categoriesInput<?= $invoice->type; ?>" name="category_id" class="form-control">
                    <?php foreach ($categories as $category): ?>
                      <option value="<?= $category->id; ?>" <?= ($category->id == $invoice->category_id ? "selected" : ""); ?>><?= $category->name; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="optionsRadios1">Unica: </label>
                  <input data-checkbox="true" name="repeat_when" type="radio" id="optionsRadios1" value="single" <?= ($invoice->repeat_when == "single" ? "checked" : ""); ?>>
                  <label for="optionsRadios2">Fixa: </label>
                  <input data-checkbox="true" type="radio" name="repeat_when" id="optionsRadios2" value="fixed" <?= ($invoice->repeat_when == "fixed" ? "checked" : ""); ?>>
                  <label for="optionsRadios3">Parcelada: </label>
                  <input data-checkbox="true" type="radio" name="repeat_when" id="optionsRadios3" value="enrollment" <?= ($invoice->repeat_when == "enrollment" ? "checked" : ""); ?>>
                </div>

                <div class="form-group">
                  <label style="width: 100%" data-inputcheck="optionsRadios2" class="<?= ($invoice->repeat_when == "fixed" ? "" : "hidden-input"); ?>">
                    <select class="form-control" name="period">
                      <option value="month" <?= ($invoice->repeat_when == "month"? "selected" : ""); ?>>Month</option>
                      <option value="year" <?= ($invoice->repeat_when == "year"? "selected" : ""); ?>>Year</option>
                    </select>
                  </label>
                  <label  data-inputcheck="optionsRadios3" class="<?= ($invoice->repeat_when == "enrollment" ? "" : "hidden-input"); ?>">
                    <input class="radius" type="number" value="<?= ($invoice->enrollments ?? 1); ?>" min="1" max="420" placeholder="1 parcela" name="enrollments">
                  </label>
                </div>

              </div>
              <div class="modal-footer">
                <a href="<?= url("/app/invoice/{$invoice->id}"); ?>" class="btn btn-danger">Excluir</a>
                <button type="submit" class="btn btn-primary">Salvar alterações</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




