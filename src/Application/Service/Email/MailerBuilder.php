<?php

namespace DevFighters\Utils\Application\Service\Email;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailerBuilder
{
    public const string MAILER_SENDER_EMAIL = 'MAILER_SENDER_EMAIL';
    public const string MAILER_SENDER_NAME = 'MAILER_SENDER_NAME';

    private Email $email;

    public function __construct(private readonly Environment $twig)
    {
    }

    public function createEmail(): self
    {
        $this->email = new Email();
        $this->setDefaultSender();

        return $this;
    }

    public function destroyEmail(): self
    {
        unset($this->email);

        return $this;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setDefaultSender(): self
    {
        return $this->setSender(
            address: $this->getEnv(self::MAILER_SENDER_EMAIL),
            name: $this->getEnv(self::MAILER_SENDER_NAME));
    }

    public function setSender(string $address, string $name = ''): self
    {
        $replyTo = new Address($address, $name);
        $this->email->from($replyTo);

        return $this;
    }

    /**
     * @return Address[]
     */
    public function getSender(): array
    {
        return $this->email->getFrom();
    }

    public function setRecipient(string $recipient): self
    {
        $this->email->to($recipient);

        return $this;
    }

    public function setRecipients(array $recipients): self
    {
        $this->email->to(...$recipients);

        return $this;
    }

    /**
     * @return Address[]
     */
    public function getRecipients(): array
    {
        return $this->email->getTo();
    }

    public function setSubject(string $subject): self
    {
        $this->email->subject($subject);

        return $this;
    }

    public function getSubject(): string
    {
        return $this->email->getSubject();
    }

    public function setReplyTo(string $address, string $name = ''): self
    {
        $replyTo = new Address($address, $name);
        $this->email->replyTo($replyTo);

        return $this;
    }

    /**
     * @return Address[]
     */
    public function getReplyTo(): array
    {
        return $this->email->getReplyTo();
    }

    public function setHtml(string $html): self
    {
        $this->email->html($html);

        return $this;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function setHtmlByTemplate(
        string $twigPath,
        array $contextParameters = []): self
    {
        $html = $this->renderTwig($twigPath, $contextParameters);
        $this->setHtml($html);

        return $this;
    }

    public function getHtml(): ?string
    {
        return $this->email->getHtmlBody();
    }

    public function setText(string $text): self
    {
        $this->email->text($text);

        return $this;
    }

    public function getText(): ?string
    {
        return $this->email->getTextBody();
    }

    public function addAttach($body, ?string $name = null, ?string $contentType = null): self
    {
        $this->email->attach(
            $body,
            $name,
            $contentType
        );

        return $this;
    }

    protected function getEnv(string $key): mixed
    {
        return $_ENV[$key] ?? null;
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    private function renderTwig(
        string $twigPath,
        array $contextParameters = []): string
    {
        $html = $this->twig->render($twigPath, $contextParameters);

        return mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    }
}
