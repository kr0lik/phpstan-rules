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
docker pull composer:2.2.20
docker run -v .:/app --rm composer:2.2.20 composer install
docker run -v .:/app --rm composer:2.2.20 vendor/bin/php-cs-fixer fix
docker run -v .:/app --rm composer:2.2.20 vendor/bin/phpstan analyse
docker run -v .:/app --rm composer:2.2.20 vendor/bin/phpunit tests
```