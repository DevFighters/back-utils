<?php

namespace DevFighters\Utils\Infrastructure\Fixtures\Init;

use DevFighters\Utils\Domain\Entity\App\AppCountry;
use DevFighters\Utils\Domain\Entity\App\AppCountryAdministrativeArea;
use DevFighters\Utils\Domain\Enum\AppCountryAdministrativeAreaEnum;
use DevFighters\Utils\Domain\Enum\AppCountryEnum;
use DevFighters\Utils\Domain\Repository\App\AppCountryAdministrativeAreaRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppCountryAdministrativeAreaFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function __construct(
        private readonly AppCountryAdministrativeAreaRepository $appCountryAdministrativeAreaRepository
    )
    {
    }

    public function load(ObjectManager $manager): void
    {

        //PRE CHARGER LES DATAS
        $this->appCountryAdministrativeAreaRepository->findAll();

        //INSERT ou UPDATE LES DATAS
        foreach (AppCountryAdministrativeAreaEnum::cases() as $value) {
            $id = $value->value;

            [$parentCode, $code] = explode('_', $value->name);

            /**
             * @var $parentEnum AppCountryAdministrativeAreaEnum
             */
            $parentEnum = constant(AppCountryEnum::class . '::' . $parentCode);

            $parent = $this->getReference(AppCountryFixtures::REFERENCE . $parentEnum->value, AppCountry::class);
            $entity = $this->appCountryAdministrativeAreaRepository->find($id) ?? new AppCountryAdministrativeArea();
            $entity
                ->setId($id)
                ->setCountry($parent)
                ->setCode($code)
                ->setName($value->name());
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppCountryFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['init'];
    }

}
