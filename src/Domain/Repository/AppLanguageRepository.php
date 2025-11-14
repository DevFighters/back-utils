<?php

namespace DevFighters\Utils\Domain\Repository;

use DevFighters\Utils\Domain\Entity\AppLanguage;
use DevFighters\Utils\Domain\RepositoryUtils\RepositoryAbstract;
use DevFighters\Utils\Domain\RepositoryUtils\Trait\PersisterTrait;
use Doctrine\Persistence\ManagerRegistry;
use Random\RandomException;

/**
 * @extends RepositoryAbstract<AppLanguage>
 *
 * @method AppLanguage      findOne($id, $lockMode = null, $lockVersion = null)
 * @method AppLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppLanguage[]    findAll()
 * @method AppLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppLanguageRepository extends RepositoryAbstract
{

    use PersisterTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppLanguage::class);
    }

    /** @throws RandomException */
    public function getOneRandom(): ?AppLanguage
    {
        $count = $this->count();
        if ($count === 0) {
            return null;
        }

        $randomOffset = random_int(0, $count - 1);

        return $this->createQueryBuilder('appLanguage')
            ->setFirstResult($randomOffset)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}