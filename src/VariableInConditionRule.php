<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Stmt\If_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

final class VariableInConditionRule implements Rule
{
    public function getNodeType(): string
    {
        return If_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof If_) {
            return [];
        }

        try {
            $this->recursiveCheck($node->cond);
        } catch (ShouldNotHappenException $e) {
            return [$e->getMessage()];
        }

        return [];
    }

    /**
     * @throws ShouldNotHappenException
     */
    private function recursiveCheck(Expr $expr): void
    {
        $this->checkAssign($expr);

        if (!$expr instanceof BinaryOp) {
            return;
        }

        $this->recursiveCheck($expr->left);
        $this->recursiveCheck($expr->right);
    }

    /**
     * @throws ShouldNotHappenException
     */
    private function checkAssign(Expr $expr): void
    {
        if ($expr instanceof Assign) {
            /** @var Expr\Variable $var */
            $var = $expr->var;
            $name = is_string($var->name) ? $var->name : 'unfefinded';

            throw new ShouldNotHappenException(sprintf('Assignment $%s in condition.', $name));
        }
    }
}
