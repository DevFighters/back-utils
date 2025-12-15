<?php

namespace DevFighters\Utils\Domain\Entity\App;

use DevFighters\Utils\Domain\Repository\App\AppCountryAdministrativeAreaRepository;
use DevFighters\Utils\Domain\Trait\CommonCode;
use DevFighters\Utils\Domain\Trait\CommonDate;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppCountryAdministrativeAreaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AppCountryAdministrativeArea
{
    use CommonDate;
    use CommonCode;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    private int $id;

    #[ORM\ManyToOne(targetEntity: AppCountry::class, inversedBy: 'administrativeAreas')]
    #[ORM\JoinColumn(nullable: false)]
    private AppCountry $country;

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

    public function getCountry(): AppCountry
    {
        return $this->country;
    }

    public function setCountry(AppCountry $country): static
    {
        $this->country = $country->addAppCountryAdministrativeArea($this);
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
