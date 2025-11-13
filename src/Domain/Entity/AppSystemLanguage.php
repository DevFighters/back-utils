<?php

namespace DevFighters\Utils\Domain\Entity;

use DevFighters\Utils\Domain\Repository\AppSystemLanguageRepository;
use DevFighters\Utils\Domain\Trait\CommonDate;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppSystemLanguageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AppSystemLanguage
{
    use CommonDate;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 5, unique: true)]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

}