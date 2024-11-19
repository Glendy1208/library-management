# Library Management API

A RESTful API built with **Laravel 11** for managing authors and books in a library system. The API provides endpoints to perform CRUD operations on authors and books, along with additional features like caching, validation, and error handling for efficient performance with caching.

---

## Features

1. **Authors Management**
   - Create, update, delete, and retrieve authors.
   - View all books associated with a specific author.

2. **Books Management**
   - Create, update, delete, and retrieve books.

3. **Associate**
   - Associate books with specific authors.

4. **Error Handling**
   - Detailed error responses for validation, not found, and conflict errors.

5. **Caching**
   - Frequently accessed data (e.g., author lists, book lists, and book list of specific author) cached for performance.

6. **Testing**
   - Comprehensive feature and edge case testing using PHPUnit.

---

## Installation
1. make sure you have already install composer and local server environments like laragon or xampp
2. clone this repository in terminal, with this command "git clone  https://github.com/Glendy1208/library-management.git"
3. change your directory in "library-mannagement" folder
4. copy and paste the file named ".env example", after that rename the copy file (.env copy.example) into ".env"
5. in .env setting your connection like this :
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=library
    - DB_USERNAME=root
    - DB_PASSWORD=
5. in .env, add "CACHE_DRIVER=file" after "CACHE_STORE", for performance tunning.
6. turn on the local server
7. create a database named "library"
8. in terminal run "composer install"
9. run "php artisan key:generate"
10. run "php artisan migrate"
11. run "php artisan serve"

---

## Seeder
in the folder seeder, you can use a factory create or my mannually create. <br>
after that run "php artisan migrate:fresh --seed"

---

## Testing (PHPunit)
For testing, I use PHPunit because it default testing in laravel. so no need to installing PHPunit.


**Step to run testing**
1. create a folder named "Unit" in folder "tests"
2. run "php artisan test"

**Testing Scheme**
1. Author Test
    - Test creating, retrieving, updating, and deleting authors.
2. Book Test
    - Test creating, retrieving, updating, and deleting books.
3. Cases Test
    - Deletion of authors with books.
    - Empty database responses (No authors found, No books found).
    - Validation failures with missing or invalid fields.
    - Conflict errors for duplicate records (Author with this name already exists or Book with this title)
    - Record not found scenarios return 404 Not Found.