<?php

namespace DevFighters\Utils\Application\UseCase;

use App\UseCase\PDF\PdfConstructor;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

abstract class AbstractPdfExporter
{

    protected PdfConstructor $pdfConstructor;

    public function __construct(
        Environment $twig,
    )
    {
        $this->pdfConstructor = new PdfConstructor($twig);
    }

    public function downloadPdf(): Response
    {
        return $this->pdfConstructor->downloadPdf(
            $this->getTemplate(),
            $this->getName(),
            $this->getData()
        );
    }

    public function streamPdf(): Response
    {
        return $this->pdfConstructor->streamPdf(
            $this->getTemplate(),
            $this->getName(),
            $this->getData()
        );
    }

    abstract protected function getData(): array;

    abstract protected function getTemplate(): string;

    abstract protected function getName(): string;

}