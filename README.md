# laravel-cloud-cost

## Features
- Sync AWS costs and storage to database
- Users can set tags rules in config to query AWS cost

## Requirements

- PHP >= 8.1;
- composer.

## Features

- Support AWS cost

## Installation

```bash
composer require onramplab/laravel-cloud-cost
php artisan vendor:publish --provider="OnrampLab\CloudCost\CloudCostServiceProvider"
php artisan migrate
```

## Sync costs to database
```
php artisan cloud-cost:sync aws_default 2023 1 
```

## Running Tests:

    php vendor/bin/phpunit

 or

    composer test

## Code Sniffer Tool:

    php vendor/bin/phpcs --standard=PSR2 src/

 or

    composer psr2check

## Code Auto-fixer:

    composer psr2autofix
    composer insights:fix
    rector:fix

## Building Docs:

    php vendor/bin/phpdoc -d "src" -t "docs"

 or

    composer docs

## Changelog

To keep track, please refer to [CHANGELOG.md](https://github.com/onramplab/laravel-package-template/blob/master/CHANGELOG.md).

## Contributing

1. Fork it.
2. Create your feature branch (git checkout -b my-new-feature).
3. Make your changes.
4. Run the tests, adding new ones for your own code if necessary (phpunit).
5. Commit your changes (git commit -am 'Added some feature').
6. Push to the branch (git push origin my-new-feature).
7. Create new pull request.

Also please refer to [CONTRIBUTION.md](https://github.com/onramplab/laravel-package-template/blob/master/CONTRIBUTION.md).

## License

Please refer to [LICENSE](https://github.com/onramplab/laravel-package-template/blob/master/LICENSE).

## AWS setting
- login AWS
- Menu > Security credentials > User groups
- add "Permissions to "Permissions policies"
  - "Cost-Explorer-Service-Admin"



