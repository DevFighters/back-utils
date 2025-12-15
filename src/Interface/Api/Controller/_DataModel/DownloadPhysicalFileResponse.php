<?php

namespace DevFighters\Utils\Interface\Api\Controller\_DataModel;

use DevFighters\Utils\Application\DTO\File\PhysicalFileDTO;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadPhysicalFileResponse extends BinaryFileResponse {

    public function __construct(
        PhysicalFileDTO $file,
        int $status = 200,
        array $headers = [],
        bool $public = true,
        ?string $contentDisposition = null,
        bool $autoEtag = false,
        bool $autoLastModified = true) {

        parent::__construct(
            $file->getPhysicalPath(),
            $status,
            $headers,
            $public,
            $contentDisposition,
            $autoEtag,
            $autoLastModified);

        $this->setContentDisposition(
            disposition: ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            filename: $file->getName()
        );
    }

}