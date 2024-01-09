# DeskTime affiliate app
Application used for creating affiliate urls, registering other users through them, and some basic statistics about click events.

## Pre-requisites
Project runs on minimal required PHP **version 8.2**.
Migration files are provided, database seeder is set for initial user (email: `test@example.com`, password: `admin`).

## Installation

1. Clone the repository
2. `cp .env.example .env` to copy environment variables onto `.env` file
3. `composer install` to install all the back-end dependencies
4. `npm install` to install all the front-end dependencies
5. `npm run dev` or `npm run build` to start Vite development server/bundle code for production usage
6. `php artisan migrate --seed` to migrate database schema and create default user along with 3 affiliate links. Be sure to use your local DB credentials
7. Lastly, `php artisan serve` to serve up the project

## What I would do better but out of scope*
1. Services should be mocked in order to simplify testing with specific return values but for the sake of "testability" they are mockable/swappable with the help of interfaces.
2. There should be a lot more tests, I have tested only happy paths in order to show my skill-set, but there are definitely scenarios to test out more.
3. More refactoring when it comes to how clean are controllers. For a larger app, that would be a concern, but here it would delve into "premature optimization".
4. There should be more consistent logging for development purposes as it's only done in affiliation flow.
5. Something like Laravel Pint be used for more consistent code-style.

\* Since these 'out of scope' things are not done, I would at least present them as further steps in order to improve the app - I have not done them, but I know they should be.
