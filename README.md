# Bike api

The Police want to be more efficient in resolving stolen bike cases. They decided to build a software that can automate their processes

## **Installation**

Make sure you have these requirements on your local machine please:
- PHP
- MySql
- Composer

You should **create two databases**, the second one is for the **test** purposes, define your main database connection config in `.env` file and the test database connection config in `phpunit.xml` file. 

Then follow below instruction:

- Install composer depenencies using `composer install`
- Copy the `.env.example` file to `.env`
- Define your secure `APP_KEY` in `.env` file
- Run `php artisan migrate` to create tables in your database
- Serve the app using `php -S localhost:8000 public/index.php` or any other port

## **Roles/Requirements**

- Bike owners can report a stolen bike.
- A bike can have multiple characteristics: license number, color, type, full name of the owner, date, and description of the theft.
- The Police can increase or decrease the number of police officers.
- Each police officer should be able to search bikes by different characteristics in a database and see which police officer is responsible for a stolen bike case.
- New stolen bike cases should be automatically assigned to any free police officer.
- A police officer can only handle one stolen bike case at a time.
- When the Police find a bike, the case is marked as resolved and the responsible police officer becomes available to take a new stolen bike case.
- The system should be able to assign unassigned stolen bike cases automatically when a police officer becomes available.

- Scope

  - API Development (BP)
  - Transaction (CC)
  - Audit log
  - Unit / Integration

- Extra

  - publish client package (part of release)
  - stub
  - clean architecture
