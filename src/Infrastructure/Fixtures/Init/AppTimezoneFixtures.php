<?php

namespace DevFighters\Utils\Infrastructure\Fixtures\Init;

use DevFighters\Utils\Domain\Entity\App\AppTimezone;
use DevFighters\Utils\Domain\Enum\AppTimezoneEnum;
use DevFighters\Utils\Domain\Repository\App\AppTimezoneRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppTimezoneFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private readonly AppTimezoneRepository $appTimezoneRepository,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        //PRE CHARGER LES DATAS
        $this->appTimezoneRepository->findAll();

        //INSERT ou UPDATE LES DATAS
        foreach (AppTimezoneEnum::cases() as $value) {
            $id = $value->value;
            $entity = $this->appTimezoneRepository->find($id) ?? new AppTimezone();
            $entity
                ->setId($id)
                ->setCode($value->code());
            $manager->persist($entity);
            $this->addReference($id,$entity);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }

}
