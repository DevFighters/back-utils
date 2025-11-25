<?php

namespace DevFighters\Utils\Interface\Command;

use App\version2\Domain\Repository\LoggerApiErrorRepository;
use DateMalformedStringException;
use DateTime;
use DevFighters\Utils\Infrastructure\Services\Telegram\TelegramService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(name: 'app:telegram:send_errors', description: 'Send errors to Telegram')]
class SendErrorsToTelegram extends Command
{

    public function __construct(
        public EntityManagerInterface   $entityManager,
        public LoggerApiErrorRepository $loggerApiErrorRepository,
        public TelegramService          $telegramService)
    {
        parent::__construct();
    }

    /**
     * @throws DateMalformedStringException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $date = new DateTime()->modify('-10 minutes');
        $errors = $this->loggerApiErrorRepository->getAllWithUserAndInsertedAfter($date);
        $errorCount = count($errors);
        if ($errorCount > 0 && $this->telegramService->isInitialized()) {
            $message = "MG-Quote : User errors have been detected x$errorCount";
            $this->telegramService->sendMessageToDefaultChat($message);
        }

        return Command::SUCCESS;
    }

}
