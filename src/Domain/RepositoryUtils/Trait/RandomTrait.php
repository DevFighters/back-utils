<?php

namespace DevFighters\Utils\Domain\RepositoryUtils\Trait;

use Random\RandomException;

/** @phpstan-ignore trait.unused */
trait RandomTrait
{
    /**
     * @throws RandomException
     */
    public function findOneRandom(): mixed
    {
        $count = $this->count();
        if (0 === $count) {
            return null;
        }

        return $this->createQueryBuilder('c')
            ->setFirstResult(random_int(0, $count - 1))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
