# Basic event booking system

This is the READ.ME file for the Hiring technial task.

This project is a PHP/Laravel project, to implement a basic event booking system.

To get the project on your machine first you need to clone it, then `cd booking-portal/`
run `composer install`,
To run the database migration you need first to create a database, the one in the .env file is `task-db`, then replace it in the .env file and write your mysql username and password.
Then run `php artisan key:generate` to geneate your key.
After it's done you now should be able to use it.

To start working with the seeders, your need to run the migration files first by `php artisan migrate`, then you can seed it by `php artisan db:seed`.

In the UserBookedTicketsSeeder you will write the number of records you need, and you will notice that it's using the UserBookedTicketsFactory in which:
The tickets seeded has 2 types which are those 2 provided in the task email, you can comment and uncomment the type you wish to seed.

Project Structure:
------------------

The project logic is mainly in the UsersBookingController. It has the User, tickets categories and user booked tickets Models, Servics and repositories, and in each file is the logic required to handle the entity business.
