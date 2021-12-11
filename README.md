

## Installation Guide
1.Clone the repository first to your own project directory

2.Cd to your project, and then install the depedencies 
```shell
composer install
```
Wait for the installation

3.Copy the .env file for the new .env file
```shell
cp .env.example .env
```

4.Set the environment variables in .env, just set the db name which is same with the db name from the sql dump 

5.Import the sql dump in your local administration tool, example :phpMyAdmin, to run this project.

6.Generate the secret key in .env file
```shell
php artisan generate:key
```

7.Turn on the artisan server
```shell
php artisan serve
```

8.Go to http://127.0.0.1:8000/list-obat url for the homepage
