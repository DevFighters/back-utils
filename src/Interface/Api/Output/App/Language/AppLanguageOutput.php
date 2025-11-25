<?php

namespace DevFighters\Utils\Interface\Api\Output\App\Language;

use DevFighters\Utils\Domain\Entity\App\AppLanguage;

readonly class AppLanguageOutput
{
    public int $id;
    public string $code;
    public string $originalName;

    public function __construct(AppLanguage $language)
    {
        $this->id = $language->getId();
        $this->code = $language->getCode();
        $this->originalName = $language->getOriginalName();

    }
}