<?php

namespace DevFighters\Utils\Infrastructure\Fixtures\Init;

use DevFighters\Utils\Domain\Entity\App\AppCountry;
use DevFighters\Utils\Domain\Enum\AppCountryEnum;
use DevFighters\Utils\Domain\Repository\App\AppCountryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppCountryFixtures extends Fixture implements FixtureGroupInterface
{

    public const string REFERENCE = 'AppCountryEnum-';

    public function __construct(
        private readonly AppCountryRepository $appCountryRepository
    )
    {
    }

    public function load(ObjectManager $manager): void
    {

        //PRE CHARGER LES DATAS
        $this->appCountryRepository->findAll();

        //INSERT ou UPDATE LES DATAS
        foreach (AppCountryEnum::cases() as $value) {
            $id = $value->value;
            $entity = $this->appCountryRepository->find($id) ?? new AppCountry();
            $entity
                ->setId($id)
                ->setCode($value->name);
            $this->addReference(self::REFERENCE . $id, $entity);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }

}
