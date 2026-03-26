# Menukarte Symfony Project

This project is a simple restaurant menu and ordering application built with Symfony.

## Features
- Dish management (`Gericht`)
- Categories (`Kategorie`)
- Order flow (`Bestellung`)
- Employee registration and login
- Admin area with EasyAdmin
- Twig-based frontend pages

## Architecture
- **Controller**: handles request and response
- **Service**: business logic for dishes and orders
- **Repository**: database access with Doctrine
- **Entity**: domain objects and relations

## Tech Stack
- PHP 7.2+
- Symfony 5.4
- Doctrine ORM
- Twig
- EasyAdmin
- PHPUnit

## Project Structure
```text
src/
 ├── Controller/
 ├── Entity/
 ├── Repository/
 ├── Service/
 └── Form/
```

## Setup
```bash
composer install
php bin/console doctrine:migrations:migrate
symfony server:start
```

## Tests
```bash
php bin/phpunit
```

## CI
A GitHub Actions workflow is included under `.github/workflows/ci.yml` to install dependencies and run tests automatically.
