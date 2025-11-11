<?php

namespace DevFighters\Utils\Domain\Entity;

use DevFighters\Utils\Domain\Repository\AppCountryAdministrativeAreaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppCountryAdministrativeAreaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AppCountryAdministrativeArea
{

    use CommonDate;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "smallint", options: ["unsigned" => true])]
    private int $id;

    #[ORM\ManyToOne(targetEntity: AppCountry::class, inversedBy: 'administrativeAreas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AppCountry $country = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
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

    public function getCountry(): AppCountry
    {
        return $this->country;
    }

    public function setCountry(?AppCountry $country): static
    {
        $this->country = $country;
        if (($country !== null) && !$country->getAdministrativeAreas()->contains($this)) {
            $country->addAdministrativeArea($this);
        }
        return $this;
    }

    public function getCode(): string
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
