<?php
  $user = user();
  $wallets = (new \Source\Models\WalletApp\AppWallet())->find("user_id = :id", "id={$user->id}", "id, wallet")->order("wallet")->fetch(true);

  $v->insert("views/invoice", [
    'type' => "income",
    'wallets' => $wallets,
    'categories' => (new \Source\Models\WalletApp\AppCategory())->find("type = :t", "t=income", "id, name")->fetch(true)
  ]);

  $v->insert("views/invoice", [
    'type' => "expense",
    'wallets' => $wallets,
    'categories' => (new \Source\Models\WalletApp\AppCategory())->find("type = :t", "t=expense", "id, name")->fetch(true)
  ]);

