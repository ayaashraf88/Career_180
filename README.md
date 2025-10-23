# Career 180 — Development README

This repository contains the Career 180 Laravel application.

## Quick setup (local)

Prerequisites:
- PHP 8.1+ (8.2 recommended)
- Composer
- MySQL 

### Installation 🛠️
* ``` git clone https://github.com/ayaashraf88/Career_180.git ```
* Install dependencies:
    - ``` cd Career_180```
    -  ``` composer install  ```
* Set up environment:
    
    - ``` copy .env.example .env ```
    - ``` php artisan key:generate ```
* Configure your database in .env:
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=your_db_name
    - DB_USERNAME=your_db_user
    - DB_PASSWORD=your_db_password
* Run migrations and seeders:
    - ``` php artisan migrate --seed ```
### Usage 🚀
* Start the development server:
    - ``` php artisan serve ```
* Run the test suite with:
     - ``` php artisan test ```
* Run the queue:
     - ``` php artisan queue:work ```
* Login Credintials for admin :
     - email : ```admin@Career180.com```
     - password : ```admin123```
     - link : ```/admin```   
* Login Credintials for student :
     - email : ```student@Career180.com```
     - password : ```123456```
     - link : ```/```
* You can find the screenshot of the tests in /screenshot
## "If I had more time"

- Add dedicated seeders for demo data and CI seeding
- Add more unit and integration tests (edge cases, performance)
- Add a GitHub Actions workflow for running tests on push/PR
- Improve Docker image with multi-stage builds and caching
- Add sample environment files and secrets guidance

---

