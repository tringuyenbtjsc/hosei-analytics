<?php

declare(strict_types=1);

namespace App\Enums;

use Cerbero\LaravelEnum\Concerns\Enumerates;

/**
 * @method static string DAY()
 * @method static string HOUR()
 * @method static string MONTH()
 */
enum PositionType: string
{
    use Enumerates;

    case MONTH = 'month';

    case DAY = 'day';

    case HOUR = 'hour';
}
