<?php

namespace DevFighters\Utils\Interface\Response;

use DevFighters\Utils\Application\DTO\File\PhysicalFileDTO;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ServePhysicalFileResponse extends BinaryFileResponse
{
    /**
     * @param PhysicalFileDTO $file               The file to stream
     * @param int             $status             The response status code (200 "OK" by default)
     * @param array           $headers            An array of response headers
     * @param bool            $public             Files are public by default
     * @param string|null     $contentDisposition The type of Content-Disposition to set automatically with the filename
     * @param bool            $autoEtag           Whether the ETag header should be automatically set
     * @param bool            $autoLastModified   Whether the Last-Modified header should be automatically set
     */
    public function __construct(
        PhysicalFileDTO $file,
        int $status = 200,
        array $headers = [],
        bool $public = true,
        ?string $contentDisposition = null,
        bool $autoEtag = false,
        bool $autoLastModified = true)
    {
        parent::__construct(
            $file->getPhysicalPath(),
            $status,
            $headers,
            $public,
            $contentDisposition,
            $autoEtag,
            $autoLastModified);

        $this->setContentDisposition(
            disposition: ResponseHeaderBag::DISPOSITION_INLINE,
            filename: $file->getName()
        );
    }
}
