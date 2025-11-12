<?php

namespace DevFighters\Utils\Application\UseCase\PDF;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class AbstractPdfExporter
{

    protected PdfConstructor $pdfConstructor;

    public function __construct(
        Environment $twig,
    )
    {
        $this->pdfConstructor = new PdfConstructor($twig);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function downloadPdf(): Response
    {
        return $this->pdfConstructor->downloadPdf(
            $this->getTemplate(),
            $this->getName(),
            $this->getData()
        );
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
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