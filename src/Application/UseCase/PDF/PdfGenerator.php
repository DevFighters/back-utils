<?php

namespace DevFighters\Utils\Application\UseCase\PDF;

use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PdfGenerator
{
    private Options $options;
    private Dompdf $dompdf;

    public function __construct(private readonly Environment $twig)
    {
        $this->initializeOptions();
        $this->initializeDompdf();
    }

    private function initializeOptions(): void
    {
        $this->options = new Options();
        $this->options
            ->set('isHtml5ParserEnabled', true)
            ->set('isUnicodeEnabled', true)
            ->set('isRemoteEnabled', true)
            ->set('isPhpEnabled', true);
    }

    private function initializeDomPdf(): void
    {
        $this->dompdf = new Dompdf($this->options);
        $this->dompdf->setPaper('A4');
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function buildPdf(string $template, array $data = []): string
    {
        $html = $this->render($template, $data);
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        return $this->dompdf->output();
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    private function render(string $template, array $data): string
    {
        $html = $this->twig->render($template, $data);
        $this->encodeUtf8($html);

        return $html;
    }

    private function encodeUtf8(string &$html): void
    {
        if (false === mb_detect_encoding($html, 'UTF-8', true)) {
            $html = mb_convert_encoding($html, 'UTF-8', 'auto');
        }
        $html = str_replace("\u{202F}", '&nbsp;', $html);
    }
}
