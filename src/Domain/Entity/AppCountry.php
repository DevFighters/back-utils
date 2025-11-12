<?php

namespace DevFighters\Utils\Domain\Entity;

use DevFighters\Utils\Domain\Repository\AppCountryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Countries;

#[ORM\Entity(repositoryClass: AppCountryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AppCountry
{

    use CommonDate;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    private int $id;

    #[ORM\Column(
        type: 'string',
        length: 2,
        options: ['fixed' => true])]
    private string $code;

    #[ORM\OneToMany(targetEntity: AppCountryAdministrativeArea::class, mappedBy: 'country')]
    #[ORM\OrderBy(["code" => "ASC"])]
    /** @var Collection<int, AppCountryAdministrativeArea> $administrativeAreas */
    private Collection $administrativeAreas;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getName(): string
    {
        return Countries::getName($this->code);
    }

    /** @return Collection<int, AppCountryAdministrativeArea> */
    public function getAdministrativeAreas(): Collection
    {
        return $this->administrativeAreas;
    }

    public function hasAdministrativeAreas(): bool
    {
        return count($this->administrativeAreas) > 0;
    }

    public function addAdministrativeArea(AppCountryAdministrativeArea $administrativeArea): self
    {
        if (!$this->administrativeAreas->contains($administrativeArea)) {
            $this->administrativeAreas->add($administrativeArea);
            if ($administrativeArea->getCountry() !== $this) {
                $administrativeArea->setCountry($this);
            }
        }
        return $this;
    }

    public function removeAdministrativeArea(AppCountryAdministrativeArea $administrativeArea): static
    {
        if ($this->administrativeAreas->removeElement($administrativeArea) && $administrativeArea->getCountry() === $this) {
            $administrativeArea->setCountry(null);
        }
        return $this;
    }

}
