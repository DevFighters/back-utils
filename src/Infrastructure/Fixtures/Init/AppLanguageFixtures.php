<?php

namespace DevFighters\Utils\Infrastructure\Fixtures\Init;

use DevFighters\Utils\Domain\Entity\AppLanguage;
use DevFighters\Utils\Domain\Enum\AppLanguageEnum;
use DevFighters\Utils\Domain\Repository\AppLanguageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppLanguageFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private readonly AppLanguageRepository $appLanguageRepository
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        //PRE CHARGER LES DATAS
        $this->appLanguageRepository->findAll();

        //INSERT ou UPDATE LES DATAS
        foreach (AppLanguageEnum::cases() as $value) {
            $id = $value->value;
            $entity = $this->appLanguageRepository->find($id) ?? new AppLanguage();
            $entity
                ->setId($id)
                ->setCode($value->name);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }

}
