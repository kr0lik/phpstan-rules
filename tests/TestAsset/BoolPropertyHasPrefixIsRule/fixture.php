<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules\Tests\TestAsset\BoolPropertyHasPrefixIsRule;

class Foo
{
    private bool $basketIsId = true;
    private bool $isBasketId = false;
    private ?bool $basketId = null;
}
