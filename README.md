

## Installation Guide
1.Clone the repository first

2.Cd to your project, and then install the depedencies 
```shell
composer install
```
Wait for the installation

3.Setup environment variable, copy your .env file
```shell
cp .env.example .env
```

4.Set the environment variables, just set the db name which is same with the db name from the sql dump 

5.Generate the key
```shell
php artisan generate:key
```

6.Turn on the local server
```shell
php artisan serve
```

7.Go to http://127.0.0.1:8000/list-obat url for the homepage
