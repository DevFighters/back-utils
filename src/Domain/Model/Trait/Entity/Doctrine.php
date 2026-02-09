<?php

namespace DevFighters\Utils\Domain\Model\Trait\Entity;

use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ObjectManager;

trait Doctrine
{
    protected ObjectManager $em;

    #[ORM\PrePersist]
    public function setEntityManagerWithPrePersist(PrePersistEventArgs $event): void
    {
        $this->em = $event->getObjectManager();
    }

    #[ORM\PostLoad]
    public function setEntityManagerWithPostLoad(PostLoadEventArgs $event): void
    {
        $this->em = $event->getObjectManager();
    }
}
