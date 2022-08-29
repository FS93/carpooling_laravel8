# Carpooling - a simple CRUD Web Application

The idea of the website is a platform for carpooling. Drivers can offer a ride with their car, other users can join as passengers.

There are 2 types of users: **visitors** and **registered users**. Visitors can only search for rides. Registered users can
- edit their profile
- act as driver (offering rides, editing data regarding their offered rides) and 
- act as passenger (joining and cancelling rides). 

## DEMO
1. create MySQL database & run MySQL server
2. change DB settings in `.env (mainly DB_DATABASE, DB_USERNAME, DB_PASSWORD)
3. flush database with `php artisan migrate:rollback && php artisan migrate`
4. generate dummy data for users & rides (e.g. 10 each)
```
php artisan tinker
> \App\Models\User::factory()->count(10)->create();
> \App\Models\Ride::factory()->count(10)->create();
```
5. run webserver with `php artisan serve`
6. open `localhost:8000` (or 127.0.0.1:8000) with a webbrowser


## Used Techniques
- **Webframework**: Laravel 8
- **ORM**: Eloquent
- **Database**: MySQL (used Database Migrations in Laravel to keep track of changes)
- **Frontend**: 
  - Bootstrap as Toolkit 
  - jQuery
  - Blade Templates & Blade Component for CSS Templates
- **Authentication**: Laravel Breeze
- **Test Data**: PHP Faker

## Architecture
- RidesController contains CRUD methods
- Routes return methods from Controller
- Factories for Rides & Users to generate dummy data with PHP Faker
- Form validation on submit
- AJAX Request for Joining / Unjoining Rides

## Features
- Guest
  - search for rides
  - register
- User
  - edit profile
  - join rides
  - ... as a Driver
    - edit rides
    - delete rides
    - see passengers
  - ... as a Passenger
    - unjoin
    - see driver


## (Possible) ToDos
- more validation (with customized messages)
- frontend: validation for "Edit Rides" (shall be impossbile to reduce number of seats below number of already booked seats)
- use more Blade Templates to avoid duplicate code
- consistently use AJAX instead of page reload
- separate JavaScript file for custom functions
- use one Bootstrap Modal for each user interaction instead of one per ride & interaction (less HTML)
- layout
- more responsiveness (table is too big for mobile devices)
- bug for the join / unjoin buttons in the searchresult - need double click because modal is not
properly hidden / showed
