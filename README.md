<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About eduCMS

eduCMS is a simple Content Management System (CMS) for educational articles, using PHP, MySQL and Laravel, for code interview testing, with some functionalities:

- RESTful API to create, read, update, and delete (CRUD) articles in the database.
- A simple, definitely not fancy, UI where end users can perform CRUD operations on articles using the APIs.
- Unit testing to ensure the APIs work accordingly.
- User authentication to perform CRUD operations.
- A very simple search function where end users can search for articles by title

## Installing eduCMS

1. Install [Docker](https://www.docker.com/products/docker-desktop/)
2. Open a terminal, go to root folder for project and run command './vendor/bin/sail up' to create containers.
3. Confirm .env file is there and has appropriate info for database.
4. Open a laravel container terminal in docker and run command: ´php artisan migrate´ to create database and tables.
5. Open a second terminal in same container and run ´npm run dev´ to run needed servers (vite and php).
6. Visit app on [http://localhost](http://localhost)
7. Register a user and use it all.
8. For API usage, get to the collection's [repository](https://github.com/sgtq/educms-api) and Import to [Postman](https://www.postman.com/downloads/). Run get_token first to log in.
9. To Test automatically, open a new terminal into container and run command ´php artisan test´ which will all automatic tests.

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The eduCMS is owned by Gaston Quittner. The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
