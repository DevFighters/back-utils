<?php

namespace DevFighters\Utils\Domain\Entity\App;

use DateInvalidTimeZoneException;
use DateTimeZone;
use DevFighters\Utils\Domain\Repository\App\AppTimezoneRepository;
use DevFighters\Utils\Domain\Trait\CommonCode;
use DevFighters\Utils\Domain\Trait\CommonDate;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppTimezoneRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AppTimezone
{

    use CommonDate;
    use CommonCode;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    private int $id;

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
        return new DateTimeZone($this->getCode());
    }

}
