<?php
namespace App\Consts;

class ShoppingItemStatusConst
{
    const PURCHASED = '0';

    const PURCHASED_NAME = '購入済';

    const PURCHASING_TARGET = '1';

    const PURCHASING_TARGET_NAME = '購入対象';

    const SHOPPING_ITEM_STATUS_LIST = [
        self::PURCHASED => self::PURCHASED_NAME,
        self::PURCHASING_TARGET => self::PURCHASING_TARGET_NAME,
    ];
}
