<?php

namespace DevFighters\Utils\Domain\Repository;

use DevFighters\Utils\Domain\RepositoryUtils\RepositoryAbstract;
use DevFighters\Utils\Domain\RepositoryUtils\Trait\PersisterTrait;
use DevFighters\Utils\Domain\Entity\AppCountry;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends RepositoryAbstract<AppCountry>
 *
 * @method AppCountry      findOne($id, $lockMode = null, $lockVersion = null)
 * @method AppCountry|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppCountry|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppCountry[]    findAll()
 * @method AppCountry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppCountryRepository extends RepositoryAbstract
{
    use PersisterTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppCountry::class);
    }

    /** @return AppCountry[] */
    public function getAll(): array
    {
        return $this->createQueryBuilder('appCountry')
            ->addSelect('administrativeAreas')
            ->leftJoin('appCountry.administrativeAreas', 'administrativeAreas')
            ->orderBy('appCountry.code', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
