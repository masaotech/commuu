<?php
namespace App\Consts;

class UserRoleConst
{
    const ADMIN = '1';

    const ADMIN_NAME = '管理者';

    const GENERAL = '2';

    const GENERAL_NAME = '一般';

    const USER_ROLE_LIST = [
        self::ADMIN => self::ADMIN_NAME,
        self::GENERAL => self::GENERAL_NAME,
    ];
}
