<?php $v->layout("theme") ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <?= flash(); ?>
            <form action="<?= url("/app/filter")?>" method="post" class="d-inline-flex">
              <input type="hidden" name="filter" value="<?= $type; ?>">
              <div class="form-row">
                <div class="form-group col-ms-3 text-center mx-2">
                  <label>
                    <select name="status" class="form-control">
                      <option value="all" <?= (empty($filter->status) ? "selected" : ""); ?> >Todas</option>
                      <option value="paid" <?= (!empty($filter->status) && $filter->status == "paid" ? "selected" : ""); ?>> <?= ($type == "income" ? "Receitas recebidas" : "Despesas pagas"); ?></option>
                      <option value="unpaid" <?= (!empty($filter->status) && $filter->status == "unpaid" ? "selected" : ""); ?> ><?= ($type == "income" ? "Receitas não recebidas" : "Despesas não pagas"); ?></option>
                    </select>
                  </label>
                </div>

                <div class="form-group col-ms-3 text-center mx-2">
                  <label>
                    <select name="category" class="form-control">
                      <option value="all">Todas</option>
                      <?php foreach ($categories as $category): ?>
                        <option <?= (!empty($filter->category) && $filter->category == $category->id ? "selected" : ""); ?> value="<?= $category->id; ?>"><?= $category->name; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </label>
                </div>

                <div class="form-group col-ms-3 text-center mx-2">
                  <label>
                    <input type="text" class="mask-month form-control" name="date" value="<?= (!empty($filter->date) ? $filter->date : "") ?>" placeholder="mm/yyyy" maxlength="7">
                  </label>
                </div>

                <div class="form-group col-ms-3 mx-3">
                  <button type="submit" class="btn btn-outline-primary"><i class="fas fa-funnel-dollar"></i></button>
                </div>
              </div>

            </form>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
              <thead>
              <tr>
                <th>DESCRIÇÃO</th>
                <th>VENCIMENTO</th>
                <th>CATEGORIA</th>
                <th style="width: 40px">PARCELA</th>
                <th>VALOR</th>
                <th>STATUS</th>
              </tr>
              </thead>
              <tbody>
              <?php if (!$invoices): ?>
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Oops!</h5>
                  Você não possui <?= ($type == "income" ? "receitas" : "despesas"); ?> cadastradas!
                </div>
              <?php else: ?>
                <?php foreach ($invoices as $invoice): ?>
                  <tr>
                    <td><a href="<?= url("/app/fatura/{$invoice->id}"); ?>"><?= $invoice->description; ?></a></td>
                    <td><?= date_fmt($invoice->due_at, "d-m-Y"); ?></td>
                    <td>
                      <span><?= $invoice->category()->name; ?></span>
                    </td>
                    <td class="text-center">
                      <?php if ($invoice->repeat_when == "fixed"): ?>
                        <span class="badge bg-blue">Fixa</span>
                      <?php elseif ($invoice->repeat_when == "enrollment"): ?>
                        <span class="badge bg-blue">
                        <?= str_pad($invoice->enrollment_of, 2, 0, 0); ?> de <?= str_pad($invoice->enrollments, 2, 0,
                            0); ?>
                      </span>
                      <?php else: ?>
                        <span class="badge bg-blue">Única</span>
                      <?php endif; ?>
                    </td>

                    <td class="text-center"><?= $invoice->value; ?></td>

                    <td class="text-center">
                      <form class="balance ajax_off" action="<?= url("/app/onpaid"); ?>" method="post">
                        <div class="balance_status">
                          <input type="hidden" name="user_id" value="<?= $invoice->user_id; ?>">
                          <input type="hidden" name="id" value="<?= $invoice->id; ?>">
                          <input type="hidden" name="status" value="<?= $invoice->status; ?>">
                          <button class="btn p-0" type="submit"><span class="badge bg-<?= ($invoice->status == "paid" ? "success" : "danger"); ?>"><?= ($invoice->status == "paid" ? "Pago" : "Não Pago"); ?><i class="fas fa-exchange-alt pl-2"></i></span></button>
                        </div>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
<!--            <ul class="pagination pagination-sm m-0 float-right">-->
<!--              <li class="page-item"><a class="page-link" href="#">«</a></li>-->
<!--              <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--              <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--              <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--              <li class="page-item"><a class="page-link" href="#">»</a></li>-->
<!--            </ul>-->
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

