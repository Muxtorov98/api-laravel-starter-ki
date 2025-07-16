<p align="center"><a href="https://github.com/hdeawy/api-starter-kit" target="_blank"><img src="https://hdeawy-public-storage.s3.us-east-1.amazonaws.com/starter-installer.jpg" width="400" alt="API Starter Kit"></a></p>

<p align="center">
<a href="https://packagist.org/packages/hdeawy/api-starter-kit"><img src="https://img.shields.io/packagist/dt/hdeawy/api-starter-kit" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/hdeawy/api-starter-kit"><img src="https://img.shields.io/packagist/v/hdeawy/api-starter-kit" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/hdeawy/api-starter-kit"><img src="https://img.shields.io/packagist/l/hdeawy/api-starter-kit" alt="License"></a>
<a href="https://herd.laravel.com/new?starter-kit=hdeawy/api-starter-kit"><img src="https://img.shields.io/badge/Install%20with%20Herd-f55247?logo=laravel&logoColor=white"></a>
</p>

# Laravel API Starter Kit

## Idea Brief

The Laravel API Starter Kit is a comprehensive boilerplate designed specifically for backend developers who need to quickly scaffold RESTful APIs using Laravel. Unlike general-purpose starter kits, this one focuses exclusively on API development, implementing industry best practices like Service and Repository patterns to ensure clean, maintainable, and testable code.
This starter kit aims to solve common challenges in API development by providing a standardized structure, consistent response formats, and allowing developers to focus on business logic rather than repetitive boilerplate code.

## Core Features

The API Starter Kit includes the following core features:

- Service Class Pattern
- Repository Pattern
- Standardized API Response Structure
- API Versioning
- Query Builder (Dynamic filtering, sorting, and pagination using Spatie Query Builder)
- Authentication using JWT
- Request Validation
- Resource Transformers
- API Documentation
- Telescope for Development & Debugging.
- Code Quality Tools (Pint, Larastan, IDE Helper)
- Pest for Testing (already configured and ready to use, see current tests).
- Docker Configuration
- Git Hooks (pre-commit and pre-push to automatically run Pint, Larastan, and test suites)

### Requirements
- PHP 8.2+
- Composer
- MySQL 8.0+ / PostgreSQL 12+ / SQLite 3

### Installation

#### Using Laravel Installer
```bash
laravel new my-app --using=hdeawy/api-starter-kit
```

#### Using Composer
```bash
composer create-project hdeawy/api-starter-kit
```

#### Using Docker

- Install starter using Docker
```bash
docker run -it --rm \
    -v $(pwd):/app \
    -w /app \
    -e COMPOSER_ALLOW_SUPERUSER=1 \
    composer:2.5 \
    create-project hdeawy/api-starter-kit .
```

- Update the `.env` file with your database credentials
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=root
DB_PASSWORD=password
```

- 🔥 Start the Docker containers
```bash
sail up -d
```
- Finally, run the migrations and generate the JWT secret
```bash
sail artisan migrate
```
```bash
sail artisan jwt:secret
```

#### Manually
- Clone the repository
```bash
git clone git@github.com:hdeawy/api-starter-kit.git
cd api-starter-kit
```

- Install dependencies
```bash
composer install
```
- Copy the `.env.example` file to `.env` and set your environment variables
```bash
cp .env.example .env
```

- Final setup
```bash
php artisan key:generate
php artisan jwt:secret
php artisan migrate
```

### Testing
Run the tests with Pest:
```bash
php artisan test
```
<p align="center"><a href="https://github.com/hdeawy/api-starter-kit" target="_blank"><img src="https://hdeawy-public-storage.s3.us-east-1.amazonaws.com/tests.png" width="400" alt="API Starter Kit"></a></p>


### Laravel Pint
Code style fixer for minimalists
```bash
composer pint
```
<p align="center"><a href="https://github.com/hdeawy/api-starter-kit" target="_blank"><img src="https://hdeawy-public-storage.s3.us-east-1.amazonaws.com/pint.png" width="400" alt="API Starter Kit"></a></p>



### Larastan
Finding errors in your code:
```bash
composer stan
```
<p align="center"><a href="https://github.com/hdeawy/api-starter-kit" target="_blank"><img src="https://hdeawy-public-storage.s3.us-east-1.amazonaws.com/stan.png" width="400" alt="API Starter Kit"></a></p>


### Contributing
Thank you for considering contributing to this API Starter Kit!.  All the contribution guidelines are mentioned [here](CONTRIBUTING.md).

### Security Vulnerabilities
If you discover a security vulnerability within the starter kit, please send an e-mail to me via ahmedhdeawy@gmail.com.

### License
This Laravel API Starter Kit is open-sourced software licensed under the [MIT license](LICENSE.md).

