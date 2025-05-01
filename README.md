# phpstan-rules

Additional rules for phpstan/phpstan

# Installation

Run

```
composer require --dev kr0lik/phpstan-rules
```

Copy phpstan.neon:

    cp ./vendor/kr0lik/phpstan-rules/phpstan.example ./phpstan.neon

Edit includes in phpstan.neon

Develop:

```bash
docker pull composer:2.2.20
docker run -v .:/app --rm composer:2.2.20 composer install
docker run -v .:/app --rm composer:2.2.20 vendor/bin/php-cs-fixer fix
docker run -v .:/app --rm composer:2.2.20 vendor/bin/phpstan analyse
docker run -v .:/app --rm composer:2.2.20 vendor/bin/phpunit tests
```
