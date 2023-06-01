<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

final class BoolPropertyHasPrefixRule implements Rule
{
    public function getNodeType(): string
    {
        return Property::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $isBooleanProperty = !$node instanceof Node\Stmt\Property
            || !$node->type instanceof Node\Identifier
            || 'bool' !== $node->type->name;

        if ($isBooleanProperty) {
            return [];
        }

        if (0 === count($node->props)) {
            return [];
        }

        /** @var PropertyProperty $prop */
        $prop = current($node->props);

        if (null === $prop->name->name) {
            return [];
        }

        if ('is' !== substr($prop->name->name, 0, 2)) {
            return [sprintf('Boolean property %s does not have a prefix - is', $prop->name->name)];
        }

        return [];
    }
}
