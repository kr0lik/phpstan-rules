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

Choose one in phpstan.neon:

for PHP >=7.4: - vendor/kr0lik/phpstan-rules/extensions/general-extension-74.neon

for PHP >=8.0: - vendor/kr0lik/phpstan-rules/extensions/general-extension.neon
