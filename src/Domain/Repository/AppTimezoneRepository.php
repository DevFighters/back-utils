<?php

namespace DevFighters\Utils\Domain\Repository;

use DevFighters\Utils\Domain\RepositoryUtils\RepositoryAbstract;
use DevFighters\Utils\Domain\RepositoryUtils\Trait\PersisterTrait;
use DevFighters\Utils\Domain\Entity\AppTimezone;
use Doctrine\Persistence\ManagerRegistry;
use Random\RandomException;

/**
 * @extends RepositoryAbstract<AppTimezone>
 *
 * @method AppTimezone      findOne($id, $lockMode = null, $lockVersion = null)
 * @method AppTimezone|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppTimezone|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppTimezone[]    findAll()
 * @method AppTimezone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppTimezoneRepository extends RepositoryAbstract
{

    use PersisterTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppTimezone::class);
    }

    /** @throws RandomException */
    public function getOneRandom(): ?AppTimezone
    {
        $count = $this->count();
        if ($count === 0) {
            return null;
        }

        $randomOffset = random_int(0, $count - 1);

        return $this->createQueryBuilder('appTimezone')
            ->setFirstResult($randomOffset)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}