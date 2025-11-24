# DEV FIGHTERS - Back Utils

A mini-framework library providing utilities for Dev Fighters Symfony applications, including mailer services, data integrity checks, and standardized application entities.

REQUIREMENTS
------------
* Requires PHP >= 8.4
* Symfony 7.3
* Required PHP Extensions:
    - bcmath, ctype, curl, fileinfo, gd, iconv, intl, json, soap, zlib, pdo

## Features

- **Mailer Service**: Integrated email sending with test mode support
- **Data Integrity Checker**: Validate database and application data consistency
- **Standard App Entities**: Pre-configured entities for countries, currencies, languages, timezones, and administrative areas
- **PDF Generator**: Generate PDFs from Twig templates with DomPDF (stream or download)
- **API Platform Integration**: Built-in support for API Platform 4.2
- **JWT Authentication**: Integrated with Lexik JWT Authentication Bundle
- **Doctrine Fixtures**: Sample data loading capabilities
- **Excel Support**: PHPSpreadsheet integration for spreadsheet operations

INSTALLATION
------------
* Install with composer: composer require dev-fighters/back-utils

## Configuration

### Environment Variables

Add the following variables to your `.env` file:

- MAILER_DSN=[STRING] # e.g., smtp://user:pass@smtp.example.com:port
- MAILER_SENDER_EMAIL=[STRING] # Sender email e.g., noreply@example.com
- MAILER_SENDER_NAME=[STRING] # Sender name e.g., "Dev Fighters"
- MAILER_TEST_ACTIVATE=[BOOLEAN] # TRUE = MODE TEST ACTIVATED [DEFAULT : TRUE] Set to false in production
- MAILER_TEST_RECIPIENT=[STRING] # Surpassed recipient. All emails redirected here when test mode is active

**Note**: When `MAILER_TEST_ACTIVATE=true`, all outgoing emails will be redirected to `MAILER_TEST_RECIPIENT` instead of the intended recipients. This is useful for development and testing.


### config/services.yaml
```
services :
    DevFighters\Utils\:
        resource: '../vendor/dev-fighters/back-utils/src/'
        exclude:
          - '../vendor/dev-fighters/back-utils/src/Entity/'
          autowire: true
          autoconfigure: true
```

### config/packages/doctrine.yaml
```
doctrine:
    orm:
        entity_managers:
            default:
                mappings:
                    DevFightersUtils:
                        type: attribute
                        dir: '%kernel.project_dir%/vendor/dev-fighters/back-utils/src/Domain/Entity'
                        prefix: 'DevFighters\Utils\Domain\Entity'
                        alias: DevFightersUtils
                                dql:
                string_functions:
                    replace: DoctrineExtensions\Query\Mysql\Replace
                    MONTH: DoctrineExtensions\Query\Mysql\Month
                    YEAR: DoctrineExtensions\Query\Mysql\Year
                    ROUND: DoctrineExtensions\Query\Mysql\Round
                    GROUP_CONCAT: DoctrineExtensions\Query\Mysql\GroupConcat
                numeric_functions:
                    RAND: DoctrineExtensions\Query\Mysql\Rand
```

## Usage

### Load Sample Data

- `php bin/console doctrine:fixtures:load --append --group=init`

### Check Data Integrity

Run the integrity checker to validate your database and application data:
- `php bin/console back-utils:check`

This comand performs the following checks:

- App Countries (validates against `AppCountryEnum`)
- App Country Administrative Areas (validates against `AppCountryAdministrativeAreaEnum`)
- App Currencies (validates against `AppCurrencyEnum`)
- App Languages (validates against `AppLanguageEnum`)
- App Timezones (validates against `AppTimezoneEnum`)

### Available Entities

The library provides the following standard entities:
- `AppCountry` - Country definitions
- `AppCountryAdministrativeArea` - Administrative divisions (states, provinces, etc.)
- `AppCurrency` - Currency definitions
- `AppLanguage` - Language definitions
- `AppTimezone` - Timezone configurations

## Development

### Docker Support

If you're developing this library locally with Docker:

`cd .docker && docker compose up -d --build`

## Dependencies

Key dependencies include:
- API Platform 4.2
- Doctrine ORM 3.0
- Symfony 7.3 components
- Lexik JWT Authentication Bundle
- PHPSpreadsheet 5.2

For the complete list, see composer.json.

## Documentation

- [Convention GIT](./docs/CONVENTIONS_GIT_NAMING.md)
- [Convention DEV](./docs/CONVENTIONS_DEV.md)
- [Convention Data Fixtures](./docs/DATA_FIXTURES.md)

## License

**Proprietary** - This software is the exclusive property of Dev Fighters. All rights reserved.

Unauthorized copying, distribution, modification, or use of this software, via any medium, is strictly prohibited without explicit written permission from Dev Fighters.

## Authors

### Dev Fighters

For more information or support, please contact the [Dev Fighters](https://dev-fighters.fr/) team.
