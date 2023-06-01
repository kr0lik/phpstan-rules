<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules\Tests\TestAsset\PhpdocNotNeededRule;

/**
 * Class A.
 *
 * other comments
 */
class A implements C
{
    /**
     * @var string
     */
    private $param;

    /**
     * A constructor.
     */
    public function __construct(string $param)
    {
        $this->param = $param;
    }

    /**
     * {@inheritDoc}
     */
    public function foo(): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function bar(): void
    {
    }
}

/**
 *  Trait B.
 */
trait B
{
}

/**
 *  Interface C.
 */
interface C
{
    public function foo();

    public function bar();
}
