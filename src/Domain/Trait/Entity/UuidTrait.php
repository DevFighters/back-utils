<?php

namespace DevFighters\Utils\Domain\Trait\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait UuidTrait {

    #[ORM\Column(type: Types::STRING, unique: true, nullable: false)]
    protected string $uuid;

    public function getUuid(): string {
        $this->generateUuid();
        return $this->uuid;
    }
    public function setUuid(string $uuid): static {
        $this->uuid = $uuid;
        return $this;
    }

    #[ORM\PrePersist]
    public function prePersistUuid(): void
    {
        $this->generateUuid();
    }

    protected function generateUuid(): void{
        if (!isset($this->uuid)) {
            $this->uuid = Uuid::v4()->toString();
        }
    }
    protected function isValidUuid(): bool{
        return Uuid::isValid($this->uuid);
    }
    public function equals(?self $other): bool
    {
        return $this->getUuid() === $other?->getUuid();
    }
}