<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

final class AssignVariableInReturnRule implements Rule
{
    public function getNodeType(): string
    {
        return Return_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof Return_) {
            return [];
        }

        try {
            $this->checkAssign($node->expr);
        } catch (ShouldNotHappenException $e) {
            return [$e->getMessage()];
        }

        return [];
    }

    /**
     * @throws ShouldNotHappenException
     */
    private function checkAssign(?Expr $expr): void
    {
        if ($expr instanceof Assign) {
            /** @var Expr\Variable $var */
            $var = $expr->var;
            $name = is_string($var->name) ? $var->name : 'unfefinded';

            throw new ShouldNotHappenException(sprintf('Return with assign: %s', $name));
        }
    }
}
