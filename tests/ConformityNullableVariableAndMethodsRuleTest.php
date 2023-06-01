<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules\Tests;

use kr0lik\PHPStanRules\ConformityNullableVariableAndMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ConformityNullableVariableAndMethodsRule>
 *
 * @internal
 */
class ConformityNullableVariableAndMethodsRuleTest extends RuleTestCase
{
    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__.'/TestAsset/ConformityNullableVariableAndMethodsRule/fixtureErrorReturnNull.php',
            ],
            [
                [
                    'Method return type is nullable, but property basketId is not nullable',
                    11,
                ],
                [
                    'Param name: basketId, Property is nullable 0, Params type is nullable: 1',
                    16,
                ],
            ]
        );
        $this->analyse(
            [
                __DIR__.'/TestAsset/ConformityNullableVariableAndMethodsRule/fixtureErrorPropertyNull.php',
            ],
            [
                [
                    'Method return type is nullable, but property basketId is not nullable',
                    11,
                ],
                [
                    'Param name: basketId, Property is nullable 1, Params type is nullable: 0',
                    16,
                ],
            ]
        );
        $this->analyse(
            [
                __DIR__.'/TestAsset/ConformityNullableVariableAndMethodsRule/fixtureSuccess.php',
            ],
            []
        );
    }

    protected function getRule(): Rule
    {
        return new ConformityNullableVariableAndMethodsRule();
    }
}
