<?php

namespace DevFighters\Utils\Interface\Api\Output\App\Timezone;

use DevFighters\Utils\Domain\Entity\App\AppTimezone;

readonly class AppTimezoneOutput
{
    public int $id;
    public string $code;

    public function __construct(AppTimezone $timezone)
    {
        $this->id = $timezone->getId();
        $this->code = $timezone->getCode();
    }
}