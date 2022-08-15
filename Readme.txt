git clone -b master https://github.com/rahullodhi3636/aspiretest.git

go to inside folder
run : composer update
change .env.example to .env file
change database name in .env file
DB_DATABASE : laravel_test

create database laravel_test

run : php artisan migrate
run : php artisan db:seed --class=UserSeeder
run : php artisan key:generate
run : php artisan serve

open that url to browser
http://127.0.0.1:8000


Customer credential :
userid : rahullodhi3636@gmail.com
password : 12345678

Admin credential :
userid : aspire@gmail.com
password : 12345678

run : php artisan test
#### for run test

