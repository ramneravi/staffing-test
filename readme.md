## Project setup guide

- Rename .env.example file  to .env and set DB_DATABASE, DB_TEST_DATABASE, DB_USERNAME, DB_PASSWORD.
- Create two new mysql databases with the names set in DB_DATABASE and DB_TEST_DATABASE 
- Open Terminal window and swicht to project directory.
- Run ``` composer install ```
- Run the migrations using  ``` php artisan migrate ```
- Run the datatbase seeding using ``` php artisan db:seed ```
- Run ``` npm install ``` and wait for it to install.
- Run ``` npm run dev ``` and wait for it to build css and js files
- Run  ``` php artisan serve ``` . Now server will listen to port 8000 if you want different port like 8080 you have to 
  mention it in the command like below  ``` php artisan serve  --port=8080```
- Open the browser and check the following url http://localhost:8000/rota-slot-staff  
- Datatables are used in the view you can sort the data by column values.

## PHPUnit setup guide

- php artisan migrate --database mysql_testing
- Run ./vendor/bin/phpunit or .\vendor\bin\phpunit from your project directory