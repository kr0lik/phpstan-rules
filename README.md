# phpstan-rules

Additional rules for phpstan/phpstan

# Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --dev --prefer-dist kr0lik/phpstan-rules "*"
```

or add

```
"kr0lik/phpstan-rules": "*"
```

to the require section of your `composer.json` file.


Copy phpstan.neon:

    cp ./vendor/kr0lik/phpstan-rules/phpstan.example ./phpstan.neon

Develop:

```bash
docker pull davidzapata/php-composer-alpine:8.2
docker run -v .:/var/www --rm davidzapata/php-composer-alpine:8.2 composer install
docker run -v .:/var/www --rm davidzapata/php-composer-alpine:8.2 vendor/bin/pint
docker run -v .:/var/www --rm davidzapata/php-composer-alpine:8.2 vendor/bin/phpstan analyse
docker run -v .:/var/www --rm davidzapata/php-composer-alpine:8.2 vendor/bin/phpunit tests
```