<?php

namespace DevFighters\Utils\Domain\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait CommonDate {

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private DateTimeImmutable $insAt;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private DateTimeImmutable $updAt;

    public function getInsAt(): DateTimeImmutable {
        return $this->insAt;
    }
    public function setInsAt(DateTimeImmutable $insAt): self {
        $this->insAt = $insAt;
        return $this;
    }

    public function getUpdAt(): DateTimeImmutable {
        return $this->updAt;
    }
    public function setUpdAt(DateTimeImmutable $updAt): self {
        $this->updAt = $updAt;
        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist():void{
        $dateTime = new DateTimeImmutable();
        if(!isset($this->insAt)){
            $this->insAt = $dateTime;
        }
        if(!isset($this->updAt)){
            $this->updAt = $dateTime;
        }
    }

    #[ORM\PreUpdate]
    public function preUpdate():void{
        $this->updAt = new DateTimeImmutable();
    }

}