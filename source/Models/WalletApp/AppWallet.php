<?php


namespace Source\Models\WalletApp;


use Source\Core\Model;

/**
 * Class AppWallet
 * @package Source\Models\WalletApp
 */
class AppWallet extends Model
{
    /**
     * AppWallet constructor.
     */
    public function __construct()
    {
        parent::__construct("app_wallets", ["user_id", "wallet"], ["id"]);
    }

}