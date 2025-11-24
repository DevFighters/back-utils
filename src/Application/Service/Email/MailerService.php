<?php

namespace DevFighters\Utils\Application\Service\Email;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{

    public const string MAILER_TEST_ACTIVATE = 'MAILER_TEST_ACTIVATE';
    public const string MAILER_TEST_RECIPIENT = 'MAILER_TEST_RECIPIENT';
    public const bool DEFAULT_TEST_MODE = true;

    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(
        MailerBuilder $mailerBuilder,
        bool $keepEmail = false): void
    {
        $this->ifTestModePerformActions($mailerBuilder);
        $this->mailer->send($mailerBuilder->getEmail());
        if (!$keepEmail) {
            $mailerBuilder->destroyEmail();
        }
    }

    private function setRecipientForTest(MailerBuilder $mailerBuilder): void
    {
        $recipient = $this->getEnv(self::MAILER_TEST_RECIPIENT);
        $mailerBuilder->setRecipient($recipient);
    }
    private function setSubjectForTest(MailerBuilder $mailerBuilder): void
    {
        $subject = "!-TEST-! {$mailerBuilder->getSubject()}";
        $mailerBuilder->setSubject($subject);
    }
    private function isTestMode(): bool
    {
        return filter_var(
            $this->getEnv(self::MAILER_TEST_ACTIVATE) ?? self::DEFAULT_TEST_MODE,
            FILTER_VALIDATE_BOOL
        );
    }
    private function ifTestModePerformActions(MailerBuilder $mailerBuilder): void
    {
        if ($this->isTestMode()) {
            $this->setRecipientForTest($mailerBuilder);
            $this->setSubjectForTest($mailerBuilder);
        }
    }
    private function getEnv(string $key): mixed
    {
        return $_ENV[$key] ?? null;
    }

}