<?php

namespace DevFighters\Utils\Application\UseCase\Email;

use Twig\Environment;

abstract class _Email
{


    protected string $body;

    public function __construct(protected readonly Environment $twig)
    {
    }

    abstract public function execute(): void;

    public function getSubject(): string
    {
        return "Molteni - ";
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }

    public function getBody(): string
    {
        return $this->body;
    }

}