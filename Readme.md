symfony new soap-medical-app --version=5.4
virtualhost anlegen

composer require symfony/orm-pack
composer require --dev symfony/maker-bundle

.env
DATABASE_URL="mysql://root:root@127.0.0.1:3306/medicals?serverVersion=5.7"

php bin/console doctrine:database:create
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:migrate

composer require doctrine/annotations
php bin/console make:controller SoapMedicalController

add .htaccess

Service anlegen

Controller testen