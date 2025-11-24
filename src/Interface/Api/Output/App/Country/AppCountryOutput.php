<?php

namespace DevFighters\Utils\Interface\Api\Output\App\Country;

use ApiPlatform\Metadata\ApiProperty;
use DevFighters\Utils\Domain\Entity\App\AppCountry;
use Symfony\Component\Serializer\Attribute\Ignore;

class AppCountryOutput
{

    #[ApiProperty(identifier: true)]
    public int $id;
    public string $code;
    public string $name;

    #[ApiProperty(
        openapiContext: [
            'type' => 'array',
            'description' => AppCountryAdministrativeAreaOutput::class . "[]",
        ]
    )]
    /** @var AppCountryAdministrativeAreaOutput[] $administrativeAreas */
    public array $administrativeAreas = [];

    public function __construct(AppCountry $country)
    {
        $this->id = $country->getId();
        $this->code = $country->getCode();
        $this->name = $country->getName();
        $this->createAdministrativeAreas($country);
    }

    #[Ignore]
    private function createAdministrativeAreas(AppCountry $country): void
    {
        $this->administrativeAreas = [];
        foreach ($country->getAdministrativeAreas() as $area) {
            $this->administrativeAreas[] = new AppCountryAdministrativeAreaOutput($area);
        }
    }

}