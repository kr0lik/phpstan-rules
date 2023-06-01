<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MissingPropertyFromReflectionException;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;

final class ConformityNullableVariableAndMethodsRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof ClassMethod) {
            return [];
        }

        if (null === $node->name->name) {
            return [];
        }

        if (null === $node->getStmts()) {
            return [];
        }

        if ('get' === substr($node->name->name, 0, 3)) {
            return $this->checkGetter($node->getStmts(), $node->getReturnType(), $scope->getClassReflection());
        }

        if ('set' === substr($node->name->name, 0, 3)) {
            return $this->checkSetter($node->getParams(), $scope->getClassReflection());
        }

        return [];
    }

    /**
     * @param Stmt[] $stmts
     *
     * @return array<mixed>
     */
    private function checkGetter(?array $stmts, ?Node $returnType, ClassReflection $classReflection): array
    {
        $propertyName = null;

        foreach ($stmts as $stmt) {
            $isPropertyNameExists = $stmt instanceof Return_
                && $stmt->expr instanceof Expr\PropertyFetch
                && $stmt->expr->name instanceof Node\Identifier;

            if ($isPropertyNameExists) {
                $propertyName = $stmt->expr->name->name ?? null;
            }
        }

        if (null === $propertyName) {
            return [];
        }

        try {
            $property = $classReflection->getNativeProperty($propertyName);
        } catch (MissingPropertyFromReflectionException $e) {
            return [];
        }

        $propertyPhpDocType = $property->getPhpDocType();

        $propertyNativeType = $property->getNativeType();

        $methodReturnTypeIsNullable = $returnType instanceof Node\NullableType;

        try {
            $this->checkPropertyAndReturnTypeEqual($propertyName, $methodReturnTypeIsNullable, $propertyPhpDocType, $propertyNativeType);
        } catch (ShouldNotHappenException $e) {
            return [$e->getMessage()];
        }

        return [];
    }

    /**
     * @param Param[] $params
     *
     * @return array<mixed>
     */
    private function checkSetter(array $params, ClassReflection $classReflection): array
    {
        foreach ($params as $param) {
            $name = $param->var->name ?? null;
            $isPropertyNameExists = !$param->var instanceof Expr\Variable || !is_string($name);

            if ($isPropertyNameExists) {
                return [];
            }

            try {
                $property = $classReflection->getNativeProperty($name);
            } catch (MissingPropertyFromReflectionException $e) {
                return [];
            }

            $propertyPhpDocType = $property->getPhpDocType();
            $propertyNativeType = $property->getNativeType();

            $paramsTypeIsNullable = $param->type instanceof Node\NullableType;

            try {
                $this->checkPropertyAndParamEqual($name, $paramsTypeIsNullable, $propertyPhpDocType, $propertyNativeType);
            } catch (ShouldNotHappenException $e) {
                return [$e->getMessage()];
            }
        }

        return [];
    }

    /**
     * @throws ShouldNotHappenException
     */
    private function checkPropertyAndReturnTypeEqual(string $name, bool $paramsTypeIsNullable, Type $propertyPhpDocType, Type $propertyNativeType): void
    {
        $propertyType = $propertyPhpDocType;
        $error = 'PHPDOC - Method return type is nullable, but property %s is not nullable';

        if ($propertyType instanceof MixedType) {
            $propertyType = $propertyNativeType;
            $error = 'Method return type is nullable, but property %s is not nullable';
        }

        $propertyIsNullable = $this->isPropertyNullable($propertyType);

        if ($propertyIsNullable !== $paramsTypeIsNullable) {
            throw new ShouldNotHappenException(sprintf($error, $name));
        }
    }

    /**
     * @throws ShouldNotHappenException
     */
    private function checkPropertyAndParamEqual(string $name, bool $paramsTypeIsNullable, Type $propertyPhpDocType, Type $propertyNativeType): void
    {
        $propertyType = $propertyPhpDocType;
        $error = 'PHPDOC - Param name: %s, Property is nullable %b, Params type is nullable: %b';

        if ($propertyType instanceof MixedType) {
            $propertyType = $propertyNativeType;
            $error = 'Param name: %s, Property is nullable %b, Params type is nullable: %b';
        }

        $propertyIsNullable = $this->isPropertyNullable($propertyType);

        if ($propertyIsNullable !== $paramsTypeIsNullable) {
            throw new ShouldNotHappenException(sprintf($error, $name, $propertyIsNullable, $paramsTypeIsNullable));
        }
    }

    private function isPropertyNullable(Type $propertyType): bool
    {
        if (!$propertyType instanceof UnionType) {
            return false;
        }

        $types = $propertyType->getTypes();

        foreach ($types as $type) {
            if ($type instanceof NullType) {
                return true;
            }
        }

        return false;
    }
}
