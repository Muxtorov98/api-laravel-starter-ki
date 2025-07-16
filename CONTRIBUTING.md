# Contributing to Laravel API Starter Kit

Thank you for considering contributing to the Laravel API Starter Kit! This document outlines the guidelines and process for contributing to this project.

# CONTRIBUTING

Contributions are welcome, and are accepted via pull requests.
Please review these guidelines before submitting any pull requests.

## Process

1. Clone the project
2. Create a new branch
3. Code, test, commit and push
4. Open a pull request detailing your changes. Make sure to follow the [template](.github/PULL_REQUEST_TEMPLATE.md)

## Guidelines

* Please follow the [PSR-2 Coding Style Guide](http://www.php-fig.org/psr/psr-2), enforced by [StyleCI](https://styleci.io).
* Send a coherent commit history, making sure each individual commit in your pull request is meaningful.
* You may need to [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing) to avoid merge conflicts.
* Please remember that we follow [SemVer](http://semver.org).

## Development Setup

1. Clone the repository
2. Install dependencies with `composer install`
3. Copy `.env.example` to `.env` and configure your environment
4. Run migrations with `php artisan migrate`
5. Start the development server with `php artisan serve`

## Coding Standards

- Follow PSR-12 coding style
- Write tests for new features or bug fixes
- Document any new API endpoints using OpenAPI annotations
- Use Laravel's built-in validation for form requests

## Testing

Run the test suite to ensure your changes don't break existing functionality:

```
php artisan test
```

## Documentation

- Update the README.md if you change functionality
- Document new features with examples

## Commit Guidelines

- Use clear and meaningful commit messages
- Reference issues and pull requests when relevant
- Keep commits focused on specific changes

## License

By contributing to Laravel API Starter Kit, you agree that your contributions will be licensed under the project's MIT License. 
