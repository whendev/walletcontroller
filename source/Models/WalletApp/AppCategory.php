<?php


namespace Source\Models\WalletApp;


use Source\Core\Model;

/**
 * Class AppCategory
 * @package Source\Models\WalletApp
 */
class AppCategory extends Model
{
    /**
     * AppCategory constructor.
     */
    public function __construct()
    {
        parent::__construct("app_categories", ["name", "type"], ["id"]);
    }
}