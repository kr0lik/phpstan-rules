<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules\Tests\TestAsset\VariableInConditionRule;

use Exception;

/**
 * @throws Exception
 */
function foo(): bool
{
    if (true === ($var1 = 1 === random_int(0, 1))) {
        return $var1;
    }

    if ($var2 = (1 === random_int(0, 1))) {
        return $var2;
    }

    if (true === (1 === $var3 = random_int(0, 1))) {
        return (bool) $var3;
    }

    return false;
}
