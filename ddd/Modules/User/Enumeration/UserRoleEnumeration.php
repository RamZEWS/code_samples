<?php

declare(strict_types=1);

namespace Modules\User\Enumeration;

use Core\Enumeration\BaseEnumeration;

/**
 * @method static self common()
 * @method static self admin()
 * @method static self manager()
 */
class UserRoleEnumeration extends BaseEnumeration
{
    /** @var string */
    private const COMMON = 'common';

    /** @var string */
    private const ADMIN = 'admin';

    /** @var string */
    private const MANAGER = 'manager';

    /**
     * @var string[]
     */
    protected static $names = [
        self::COMMON => 'Обычный пользователь',
        self::ADMIN => 'Администратор',
        self::MANAGER => 'Менеджер',
    ];
}