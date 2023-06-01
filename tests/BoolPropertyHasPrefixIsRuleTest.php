<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules\Tests;

use kr0lik\PHPStanRules\BoolPropertyHasPrefixRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BoolPropertyHasPrefixRule>
 *
 * @internal
 */
class BoolPropertyHasPrefixIsRuleTest extends RuleTestCase
{
    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__.'/TestAsset/BoolPropertyHasPrefixIsRule/fixture.php',
            ],
            [
                [
                    'Boolean property basketIsId does not have a prefix - is',
                    9,
                ],
            ]
        );
    }

    protected function getRule(): Rule
    {
        return new BoolPropertyHasPrefixRule();
    }
}
