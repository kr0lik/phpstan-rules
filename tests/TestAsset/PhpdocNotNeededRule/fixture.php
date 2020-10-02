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
     *
     * @param $param
     */
    public function __construct(string $param)
    {
        $this->param = $param;
    }

    /**
     * @inheritDoc
     */
    public function foo()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function bar()
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
