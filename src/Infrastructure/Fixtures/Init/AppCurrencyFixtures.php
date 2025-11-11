<?php

namespace DevFighters\Utils\Infrastructure\Fixtures\Init;

use DevFighters\Utils\Domain\Entity\AppCurrency;
use DevFighters\Utils\Domain\Enum\AppCurrencyEnum;
use DevFighters\Utils\Domain\Repository\AppCurrencyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppCurrencyFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private readonly AppCurrencyRepository $appCurrencyRepository
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        //PRE CHARGER LES DATAS
        $this->appCurrencyRepository->findAll();

        //INSERT ou UPDATE LES DATAS
        foreach (AppCurrencyEnum::cases() as $value) {
            $id = $value->value;
            $entity = $this->appCurrencyRepository->find($id) ?? new AppCurrency();
            $entity
                ->setId($id)
                ->setCode($value->name)
                ->setName($value->name())
                ->setSymbol($value->symbol());
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }

}
