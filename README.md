# DEV FIGHTERS - Back Utils

REQUIREMENTS
------------
* Requires PHP >= 8.4

INSTALLATION
------------
* Install with composer: composer require dev-fighters/back-utils

AJOUT DANS `.env`
------------
- MAILER_DSN=[STRING]
- MAILER_SENDER_EMAIL=[STRING] <-- Sender email
- MAILER_SENDER_NAME=[STRING] <-- Sender name
- MAILER_TEST_ACTIVATE=[BOOLEAN] <-- TRUE = MODE TEST ACTIVATED [DEFAULT : TRUE]
- MAILER_TEST_RECIPIENT=[STRING] <-- Surpassed recipient

UPDATE DATABASE WITH SAMPLE DATA
------------
- `php bin/console doctrine:fixtures:load --append --group=init`

CHECK INTEGRITY
------------
Check DB and APP integrity
- `php bin/console back-utils:check`
