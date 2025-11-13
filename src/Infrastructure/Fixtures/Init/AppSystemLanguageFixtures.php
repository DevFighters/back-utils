<?php

namespace DevFighters\Utils\Infrastructure\Fixtures\Init;

use DevFighters\Utils\Domain\Entity\AppSystemLanguage;
use DevFighters\Utils\Domain\Enum\AppSystemLanguageEnum;
use DevFighters\Utils\Domain\Repository\AppSystemLanguageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppSystemLanguageFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly AppSystemLanguageRepository $appSystemLanguageRepository
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        //PRE CHARGER LES DATAS
        $this->appSystemLanguageRepository->findAll();

        //INSERT ou UPDATE LES DATAS
        foreach (AppSystemLanguageEnum::cases() as $value) {
            $id = $value->value;
            $code = str_replace('_', '-', $value->name);
            $entity = $this->appSystemLanguageRepository->find($id) ?? new AppSystemLanguage();
            $entity
                ->setId($id)
                ->setCode($code)
                ->setName($value->name());
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }

}
