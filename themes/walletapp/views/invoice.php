<div class="modal fade" id="<?= $type; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i> Nova <?= ($type == 'income' ? 'Receita' : 'Despesa'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="ajax_response"><?= flash(); ?></div>
      <form action="<?= url("app/launch"); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="currency" value="BRL">
        <input type="hidden" name="type" value="<?= $type; ?>">
          <?= csrf_input(); ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="descriptionInput<?= $type; ?>">Descrição:</label>
            <input id="descriptionInput<?= $type; ?>" type="text" name="description" class="form-control" placeholder="Ex: Aluguel...">
          </div>

          <div class="form-row">
            <div class="form-group col-sm-6">
              <label for="valorInput<?= $type; ?>">Valor:</label>
              <input id="valorInput<?= $type; ?>" type="text" class="form-control" name="value" placeholder="0,00" maxlength="22">
            </div>

            <div class="form-group col-sm-6">
              <label for="dateInput<?= $type; ?>">Data:</label>
              <input class="form-control" name="due_at" type="date" value="" id="dateInput<?= $type; ?>">
            </div>
          </div>


          <div class="form-group">
            <label for="WalletInput<?= $type; ?>">Carteira:</label>
            <select id="WalletInput<?= $type; ?>" name="wallet_id" class="form-control">
              <?php foreach ($wallets as $wallet): ?>
                <option value="<?= $wallet->id; ?>"><?= $wallet->wallet; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="categoriesInput<?= $type; ?>">Categoria:</label>
            <select id="categoriesInput<?= $type; ?>" name="category_id" class="form-control">
              <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id; ?>"><?= $category->name; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
              <label for="optionsRadios1<?= $type; ?>">Unica: </label>
              <input data-checkbox="true" name="repeat_when" type="radio" id="optionsRadios1<?= $type; ?>" value="single" checked>
              <label for="optionsRadios2<?= $type; ?>">Fixa: </label>
              <input data-checkbox="true" type="radio" name="repeat_when" id="optionsRadios2<?= $type; ?>" value="fixed">
              <label for="optionsRadios3<?= $type; ?>">Parcelada: </label>
              <input data-checkbox="true" type="radio" name="repeat_when" id="optionsRadios3<?= $type; ?>" value="enrollment">
          </div>

          <div class="form-group">
            <label style="width: 100%" data-inputcheck="optionsRadios2<?= $type; ?>" class="hidden-input">
              <select class="form-control" name="period">
                <option value="month">Month</option>
                <option value="year">Year</option>
              </select>
            </label>
            <label  data-inputcheck="optionsRadios3<?= $type; ?>" class="hidden-input">
              <input class="radius" type="number" value="1" min="1" max="420" placeholder="1 parcela" name="enrollments">
            </label>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
