<?php

namespace DevFighters\Utils\Domain\Entity;

use DateInvalidTimeZoneException;
use DateTimeZone;
use DevFighters\Utils\Domain\Repository\AppTimezoneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppTimezoneRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AppTimezone
{

    use CommonDate;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    private int $id;

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

    /**
     * @throws DateInvalidTimeZoneException
     */
    public function getDateTimeZone(): DateTimeZone
    {
        return new DateTimeZone($this->getName());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

}
