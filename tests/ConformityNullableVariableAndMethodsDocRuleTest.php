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
class ConformityNullableVariableAndMethodsDocRuleTest extends RuleTestCase
{
    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__.'/TestAsset/ConformityNullableVariableAndMethodsDocRule/fixtureErrorReturnNull.php',
            ],
            [
                [
                    'PHPDOC - Method return type is nullable, but property basketId is not nullable',
                    14,
                ],
                [
                    'PHPDOC - Param name: basketId, Property is nullable 0, Params type is nullable: 1',
                    19,
                ],
            ]
        );
        $this->analyse(
            [
                __DIR__.'/TestAsset/ConformityNullableVariableAndMethodsDocRule/fixtureErrorPropertyNull.php',
            ],
            [
                [
                    'PHPDOC - Method return type is nullable, but property basketId is not nullable',
                    14,
                ],
                [
                    'PHPDOC - Param name: basketId, Property is nullable 1, Params type is nullable: 0',
                    19,
                ],
            ]
        );
        $this->analyse(
            [
                __DIR__.'/TestAsset/ConformityNullableVariableAndMethodsDocRule/fixtureSuccess.php',
            ],
            []
        );
    }

    protected function getRule(): Rule
    {
        return new ConformityNullableVariableAndMethodsRule();
    }
}
