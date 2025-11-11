<?php

namespace DevFighters\Utils\Domain\Model\Trait\Entity;

use JsonException;

trait AppEntity
{

    public function jsonSerialize(): array
    {
        $data = get_object_vars($this);
        unset($data['ins_at'], $data['upd_at']);
        return $data;
    }

    /**
     * @throws JsonException
     */
    public function json(): string
    {
        return json_encode($this->jsonSerialize(), JSON_THROW_ON_ERROR);
    }

    abstract public function getId(): int;

    abstract public function importByConstantData(array $value, array $params = []): static;

}