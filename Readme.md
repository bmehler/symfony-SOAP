# SOAP Server and Client with Symfony 5.4

## Getting the Project

To install clone the github repository

```php
git clone https://github.com/bmehler/symfony-SOAP.git
```

Change to the cloned folder and use the composer

```php
cd symfony-SOAP
composer install
```

## To do in Symfony

Change the following line in .env to use a database

```php
DATABASE_URL="mysql://<db_user>:<db_password@<db_host>/<db_name>?serverVersion=5.7"

For example:
db_user = root
db_password = root
db_host = 127.0.0.1:3306
db_name = medicals
```
Do following to work to connect your database an create a table

```php
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

You can create a virtualhost like I do
```php
<VirtualHost *:80>
    DocumentRoot "<your path to public folder>"
    ServerName <your server name>
    <Directory "<your path to public folder>">
        AllowOverride All
        Order Allow,Deny
        Allow from All
    </Directory>
</VirtualHost>
```
Insert your virtualhost in .env file
```php
APP_SOAP_URL
http://<your virtualhost>/soap/medical
```

Change the soapAction and location in the wsdl file
```php
http://<your virtualhost>/soap/medical
```