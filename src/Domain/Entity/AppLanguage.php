<?php

namespace DevFighters\Utils\Domain\Entity;

use DevFighters\Utils\Domain\Repository\AppLanguageRepository;
use DevFighters\Utils\Domain\Trait\CommonDate;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Languages;

#[ORM\Entity(repositoryClass: AppLanguageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AppLanguage
{
    use CommonDate;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 2, unique: true)]
    private string $code;


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

    public function getCodeInLower(): ?string
    {
        return strtolower($this->code);
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(?string $displayLocale = null): string
    {
        $name = Languages::getName(
            language: $this->getCodeInLower(),
            displayLocale: $displayLocale);
        return ucfirst($name);
    }

    public function getOriginalName(): string
    {
        return $this->getName($this->getCodeInLower());
    }

}