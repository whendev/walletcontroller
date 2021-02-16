<?php ?>
<div class="d-flex">
  <p class="d-flex flex-column">
    <span class="text-bold text-md"><a title="<?= $invoice->description; ?>" href="#"> <?= str_limit_words($invoice->description, 1)?> </a></span>

    <?php
      $now = new DateTime();
      $due = new DateTime($invoice->due_at);
      $expire = $due->diff($now);
      if ($expire->days == 0): ?>
          <span class="text-muted text-sm">vence hoje</span>
    <?php elseif ($now > $due): ?>
          <span class="text-muted text-sm"><?= "venceu a {$expire->days} dias" ?></span>
    <?php else: ?>
          <span class="text-muted text-sm"><?= "vence em {$expire->days} dias" ?></span>
    <?php endif; ?>
  </p>
  <div class="ml-auto d-flex flex-column text-right" style="align-self: center">
    <form class="balance ajax_off" action="<?= url("/app/onpaid"); ?>" method="post">
        <div class="balance_status">
            <input type="hidden" name="user_id" value="<?= $invoice->user_id; ?>">
            <input type="hidden" name="id" value="<?= $invoice->id; ?>">
            <input type="hidden" name="status" value="<?= $invoice->status; ?>">
            <button class="btn p-0" type="submit"><span class="badge bg-<?= ($invoice->status == "paid" ? "success" : "danger"); ?>"><?= ($invoice->status == "paid" ? "Pago" : "Não Pago"); ?><i class="fas fa-exchange-alt pl-2"></i></span></button>
        </div>
    </form>
  </div>
</div>
