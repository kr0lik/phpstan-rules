<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

class PhpdocNotNeededRule implements Rule
{
    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$this->isAllowedNode($node)) {
            return [];
        }

        $docComment = $node->getDocComment();

        if (null === $docComment) {
            return [];
        }

        return $this->checkPhpdoc($docComment);
    }

    private function isAllowedNode(Node $node): bool
    {
        return $node instanceof Node\Stmt\ClassLike
            || $node instanceof Node\FunctionLike
            || $node instanceof Node\Stmt\ClassMethod
            || $node instanceof Node\Stmt\Function_
            || $node instanceof Node\Stmt\Trait_
            || $node instanceof Node\Stmt\Interface_;
    }

    /**
     * @return RuleError[] errors
     */
    private function checkPhpdoc(Doc $phpdoc): array
    {
        $errors = [];

        if ((bool) preg_match('#^\s+\*\s+((Class|Interface|Trait)\s+[a-zA-Z0-9]+)\s*?\.?\s*$#m', $phpdoc->getText(), $matches)) {
            $errors[] = RuleErrorBuilder::message(sprintf('Phpdoc has not needed comment `%s`.', $matches[1]))
                ->line($phpdoc->getLine())
                ->build()
            ;
        }

        if ((bool) preg_match('#^\s+\*\s+(\{?@inheritdoc\}?)\s*?\.?\s*$#mi', $phpdoc->getText(), $matches)) {
            $errors[] = RuleErrorBuilder::message(sprintf('Phpdoc has not needed comment `%s`.', $matches[1]))
                ->line($phpdoc->getLine())
                ->build()
            ;
        }

        if ((bool) preg_match('#^\s+\*\s+([a-zA-Z0-9]+\s+constructor)\s*?\.?\s*$#m', $phpdoc->getText(), $matches)) {
            $errors[] = RuleErrorBuilder::message(sprintf('Phpdoc has not needed comment `%s`.', $matches[1]))
                ->line($phpdoc->getLine())
                ->build()
            ;
        }

        return $errors;
    }
}
