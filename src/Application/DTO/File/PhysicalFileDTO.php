<?php

namespace DevFighters\Utils\Application\DTO\File;

class PhysicalFileDTO {

    private string $physicalPath;
    private string $name;

    public function getPhysicalPath(): string {
        return $this->physicalPath;
    }
    public function setPhysicalPath(string $physicalPath): self {
        $this->physicalPath = $physicalPath;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

}