## Overview



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

## Seeder
in the folder seeder, you can use a factory create or my mannually create. <br>
after that run "php artisan migrate:fresh --seed"

### Testing (PHPunit)

