<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules\Tests;

use kr0lik\PHPStanRules\PhpdocNotNeededRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<PhpdocNotNeededRule>
 *
 * @internal
 * @coversNothing
 */
class PhpdocNotNeededRuleTest extends RuleTestCase
{
    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__.'/TestAsset/PhpdocNotNeededRule/fixture.php',
            ],
            [
                [
                    'Phpdoc has not needed comment `Class A`.',
                    7,
                ],
                [
                    'Phpdoc has not needed comment `A constructor`.',
                    19,
                ],
                [
                    'Phpdoc has not needed comment `@inheritDoc`.',
                    29,
                ],
                [
                    'Phpdoc has not needed comment `{@inheritdoc}`.',
                    37,
                ],
                [
                    'Phpdoc has not needed comment `Trait B`.',
                    46,
                ],
                [
                    'Phpdoc has not needed comment `Interface C`.',
                    54,
                ],
            ]
        );
    }

    protected function getRule(): Rule
    {
        return new PhpdocNotNeededRule();
    }
}
