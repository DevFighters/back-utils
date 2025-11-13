<?php

namespace DevFighters\Utils\Domain\Repository;

use DevFighters\Utils\Domain\Entity\AppSystemLanguage;
use DevFighters\Utils\Domain\RepositoryUtils\RepositoryAbstract;
use DevFighters\Utils\Domain\RepositoryUtils\Trait\PersisterTrait;
use Doctrine\Persistence\ManagerRegistry;
use Random\RandomException;

/**
 * @extends RepositoryAbstract<AppSystemLanguage>
 *
 * @method AppSystemLanguage      findOne($id, $lockMode = null, $lockVersion = null)
 * @method AppSystemLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppSystemLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppSystemLanguage[]    findAll()
 * @method AppSystemLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppSystemLanguageRepository extends RepositoryAbstract
{

    use PersisterTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppSystemLanguage::class);
    }

    public function getOneByCode(string $code): ?AppSystemLanguage
    {
        return $this->createQueryBuilder('appLanguage')
            ->where('appLanguage.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @throws RandomException */
    public function getOneRandom(): ?AppSystemLanguage
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
