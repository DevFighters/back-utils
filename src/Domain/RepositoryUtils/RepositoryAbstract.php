<?php

namespace DevFighters\Utils\Domain\RepositoryUtils;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityNotFoundException;

abstract class RepositoryAbstract extends ServiceEntityRepository
{

    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): ?object
    {
        if (is_null($id)) {
            return null;
        }
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findOne(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): object
    {
        if (is_null($id)) {
            throw new EntityNotFoundException("Entity not found : id is null");
        }
        $result = $this->find($id, $lockMode, $lockVersion);
        if (is_null($result)) {
            throw new EntityNotFoundException("Entity not found : {$this->getEntityName()} with id $id");
        }
        return $result;
    }
}