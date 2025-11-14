<?php

namespace DevFighters\Utils\Interface\Command;

use DevFighters\Utils\Application\UseCase\Checker\App\AppCountryAdministrativeAreaChecker;
use DevFighters\Utils\Application\UseCase\Checker\App\AppTimezoneChecker;
use DevFighters\Utils\Application\UseCase\Checker\App\StandardAppChecker;
use DevFighters\Utils\Application\UseCase\Checker\DataChecker;
use DevFighters\Utils\Domain\Entity\AppCountry;
use DevFighters\Utils\Domain\Entity\AppCountryAdministrativeArea;
use DevFighters\Utils\Domain\Entity\AppCurrency;
use DevFighters\Utils\Domain\Entity\AppLanguage;
use DevFighters\Utils\Domain\Entity\AppTimezone;
use DevFighters\Utils\Domain\Enum\AppCountryAdministrativeAreaEnum;
use DevFighters\Utils\Domain\Enum\AppCountryEnum;
use DevFighters\Utils\Domain\Enum\AppCurrencyEnum;
use DevFighters\Utils\Domain\Enum\AppLanguageEnum;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'back-utils:check',
    description: 'Perform system checks'
)]
class HealthCheckCommand extends Command
{

    private const array INTEGRITY_CHECKS = [
        ['checkClass' => StandardAppChecker::class, 'dataClass' => AppCountry::class, 'enumClass' => AppCountryEnum::class],
        ['checkClass' => AppCountryAdministrativeAreaChecker::class, 'dataClass' => AppCountryAdministrativeArea::class, 'enumClass' => AppCountryAdministrativeAreaEnum::class],
        ['checkClass' => StandardAppChecker::class, 'dataClass' => AppCurrency::class, 'enumClass' => AppCurrencyEnum::class],
        ['checkClass' => StandardAppChecker::class, 'dataClass' => AppLanguage::class, 'enumClass' => AppLanguageEnum::class],
        ['checkClass' => AppTimezoneChecker::class, 'dataClass' => AppTimezone::class],
    ];

    public function __construct(public EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    /**
     * @throws ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $logger = new SymfonyStyle($input, $output);
        $logger->title("Checking data integrity");
        return new DataChecker($this->entityManager, $logger, self::INTEGRITY_CHECKS)->executeChecks();
    }

}