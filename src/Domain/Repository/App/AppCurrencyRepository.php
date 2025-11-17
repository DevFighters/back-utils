<?php

namespace DevFighters\Utils\Domain\Repository\App;

use DevFighters\Utils\Domain\Entity\App\AppCurrency;
use DevFighters\Utils\Domain\RepositoryUtils\RepositoryAbstract;
use DevFighters\Utils\Domain\RepositoryUtils\Trait\PersisterTrait;
use Doctrine\Persistence\ManagerRegistry;
use Random\RandomException;

/**
 * @extends RepositoryAbstract<AppCurrency>
 *
 * @method AppCurrency      findOne($id, $lockMode = null, $lockVersion = null)
 * @method AppCurrency|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppCurrency|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppCurrency[]    findAll()
 * @method AppCurrency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppCurrencyRepository extends RepositoryAbstract
{

    use PersisterTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppCurrency::class);
    }

    /** @return AppCurrency[] */
    public function getAll(): array
    {
        return $this->createQueryBuilder('appCurrency')
            ->orderBy('appCurrency.code', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getOneByCode(string $code): ?AppCurrency
    {
        return $this->createQueryBuilder('appCurrency')
            ->where('appCurrency.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @throws RandomException */
    public function getOneRandom(): ?AppCurrency
    {
        $count = $this->count();
        if ($count === 0) {
            return null;
        }

        $randomOffset = random_int(0, $count - 1);

        return $this->createQueryBuilder('appCurrency')
            ->setFirstResult($randomOffset)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
