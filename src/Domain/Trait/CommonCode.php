<?php

namespace DevFighters\Utils\Domain\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait CommonCode
{

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $code;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getCodeInLower(): ?string
    {
        return strtolower($this->code);
    }

}