<?php

namespace DevFighters\Utils\Domain\RepositoryUtils\Trait;

use Doctrine\Persistence\ManagerRegistry;

trait PersisterTrait
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function save(mixed $entity, bool $flush = false): void
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        if ($flush) {
            $em->flush();
        }
    }

    public function remove(mixed $entity, bool $flush): void
    {
        $em = $this->getEntityManager();

        $em->remove($entity);
        if ($flush) {
            $em->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

}