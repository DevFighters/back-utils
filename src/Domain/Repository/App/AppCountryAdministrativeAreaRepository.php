<?php

namespace DevFighters\Utils\Domain\Repository\App;

use DevFighters\Utils\Domain\Entity\App\AppCountryAdministrativeArea;
use DevFighters\Utils\Domain\RepositoryUtils\RepositoryAbstract;
use Doctrine\Persistence\ManagerRegistry;
use Random\RandomException;

/**
 * @extends RepositoryAbstract<AppCountryAdministrativeArea>
 *
 * @method AppCountryAdministrativeArea      findOne($id, $lockMode = null, $lockVersion = null)
 * @method AppCountryAdministrativeArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppCountryAdministrativeArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppCountryAdministrativeArea[]    findAll()
 * @method AppCountryAdministrativeArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppCountryAdministrativeAreaRepository extends RepositoryAbstract
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppCountryAdministrativeArea::class);
    }

    /** @throws RandomException */
    public function getOneRandom(): ?AppCountryAdministrativeArea
    {
        $count = $this->count();
        if ($count === 0) {
            return null;
        }

        $randomOffset = random_int(0, $count - 1);

        return $this->createQueryBuilder('appCountryAdministrativeArea')
            ->setFirstResult($randomOffset)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
