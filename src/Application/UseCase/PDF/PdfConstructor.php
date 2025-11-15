<?php

namespace DevFighters\Utils\Application\UseCase\PDF;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PdfConstructor
{

    private PdfGenerator $pdfGenerator;

    public function __construct(Environment $twig)
    {
        $this->pdfGenerator = new PdfGenerator($twig);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function streamPdf(
        string $template,
        string $fileName,
        array  $data = []): Response
    {
        $pdf = $this->pdfGenerator->buildPdf($template, $data);
        return $this->streamResponse($pdf, $fileName);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function downloadPdf(
        string $template,
        string $fileName,
        array  $data = []): Response
    {
        $pdf = $this->pdfGenerator->buildPdf($template, $data);
        return $this->downloadResponse($pdf, $fileName);
    }


    private function streamResponse(string $pdf, string $fileName): Response
    {
        $response = new Response($pdf);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', "inline; filename=$fileName");
        return $response;
    }

    private function downloadResponse(string $pdf, string $fileName): Response
    {
        $response = new Response($pdf);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', "attachment; filename=$fileName");
        return $response;
    }

}