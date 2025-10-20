<?php

namespace DevFighters\Utils\Service\Email;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class EmailService {

    public const string MAILER_SENDER_EMAIL = 'MAILER_SENDER_EMAIL';
    public const string MAILER_SENDER_NAME = 'MAILER_SENDER_NAME';
    public const string MAILER_TEST_ACTIVATE = 'MAILER_TEST_ACTIVATE';
    public const string MAILER_TEST_RECIPIENT = 'MAILER_TEST_RECIPIENT';
    public const bool DEFAULT_TEST_MODE = true;

    private Email $email;

    public function __construct(
        private readonly MailerInterface       $mailer,
        private readonly Environment           $twig){}

    public function createEmail():self{
        $this->email = new Email();
        $this->setDefaultSender();
        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(bool $keepEmail = false):self{
        $this->ifTestModePerformActions();
        $this->mailer->send($this->email);
        if(!$keepEmail){
            unset($this->email);
        }
        return $this;
    }

    public function setDefaultSender():self{
        return $this->setSender(
            address: $this->getEnv(self::MAILER_SENDER_EMAIL),
            name: $this->getEnv(self::MAILER_SENDER_NAME));
    }
    public function setSender(string $address, string $name = ''): self{
        $replyTo = new Address($address,$name);
        $this->email->replyTo($replyTo);
        return $this;
    }
    public function setRecipient(string $recipient):self{
        $this->email->to($recipient);
        return $this;
    }
    public function setRecipients(array $recipients): self {
        $this->email->to(...$recipients);
        return $this;
    }
    public function setRecipientForTest():self{
        $recipient = $this->getEnv(self::MAILER_TEST_RECIPIENT);
        $this->setRecipient($recipient);
        return $this;
    }
    public function setSubject(string $subject): self{
        $this->email->subject($subject);
        return $this;
    }
    public function setSubjectForTest(): self{
        $subject = "!-TEST-! {$this->email->getSubject()}";
        $this->email->subject($subject);
        return $this;
    }
    public function setReplyTo(string $address, string $name = ''): self{
        $replyTo = new Address($address,$name);
        $this->email->replyTo($replyTo);
        return $this;
    }
    public function setHtml(string $html): self{
        $this->email->html($html);
        return $this;
    }
    public function setHtmlByTemplate(
        string $twigPath,
        array $contextParameters = []):void{
        $this->setHtml($this->renderTwig($twigPath,$contextParameters));
    }
    public function setText(string $text): self{
        $this->email->text($text);
        return $this;
    }
    public function addAttach($body,?string $name = null,?string $contentType = null):self{
        $this->email->attach(
            $body,
            $name,
            $contentType
        );
        return $this;
    }

    private function isTestMode():bool{
        return filter_var(
            $this->getEnv(self::MAILER_TEST_ACTIVATE) ?? self::DEFAULT_TEST_MODE,
            FILTER_VALIDATE_BOOL
        );
    }
    private function ifTestModePerformActions():void{
        if($this->isTestMode()){
            $this->setRecipientForTest();
            $this->setSubjectForTest();
        }
    }
    private function getEnv(string $key): mixed
    {
        return $_ENV[$key] ?? null;
    }
    private function renderTwig(
        string $twigPath,
        array $contextParameters = []):string{
        $html =  $this->twig->render($twigPath,$contextParameters);
        return mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    }

}