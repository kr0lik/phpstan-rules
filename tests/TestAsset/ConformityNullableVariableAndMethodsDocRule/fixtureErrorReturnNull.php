<?php

declare(strict_types=1);

namespace kr0lik\PHPStanRules\Tests\TestAsset\ConformityNullableVariableAndMethodsRule;

class Foo
{
    /**
     * @var int
     */
    private $basketId;

    public function getBasketId(): ?int
    {
        return $this->basketId;
    }

    public function setBasketId(?int $basketId): self
    {
        $this->basketId = $basketId;

        return $this;
    }
}
