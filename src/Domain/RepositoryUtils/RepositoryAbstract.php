<?php

namespace DevFighters\Utils\Domain\RepositoryUtils;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @template TEntity of object
 * @extends ServiceEntityRepository<TEntity>
 */
abstract class RepositoryAbstract extends ServiceEntityRepository
{
    /**
     * @return TEntity|null
     */
    public function find(
        mixed $id,
        LockMode|int|null $lockMode = null,
        int|null $lockVersion = null
    ): ?object {
        if ($id === null) {
            return null;
        }

        /** @var TEntity|null $entity */
        $entity = parent::find($id, $lockMode, $lockVersion);

        return $entity;
    }

    /**
     * @return TEntity
     * @throws EntityNotFoundException
     */
    public function findOne(
        mixed $id,
        LockMode|int|null $lockMode = null,
        int|null $lockVersion = null
    ): object {
        if ($id === null) {
            throw new EntityNotFoundException('Entity not found: id is null');
        }

        $entity = $this->find($id, $lockMode, $lockVersion);

        if ($entity === null) {
            throw new EntityNotFoundException(
                sprintf('Entity not found: %s with id %s', $this->getEntityName(), $id)
            );
        }

        return $entity;
    }
}