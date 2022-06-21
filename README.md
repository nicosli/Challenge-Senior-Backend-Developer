# Challenge Senior Backend Developer

## Workaround
To solve the problem, collections were used to map the result, rules were defined for the requests in order to have control and stop the unnecessary traffic.

To solve the issue of the speed of the responses, redis was used as a cache, a process is executed in the console to scan the entire table and save it in cache
```
php artisan saveDataToCache
```



## Install de project locally
This project was created with Laravel so there are several ways to install it, the suggested way is the following:

Clone the repository to your local computer
```
https://github.com/nicosli/Challenge-Senior-Backend-Developer.git
```

Install composer dependencies
```
composer install
```

This project uses Sail. Laravel Sail is a light-weight command-line interface for interacting with Laravel's default Docker development environment.

To run the containers we must execute the following command:

```
./vendor/bin/sail up
```
Sail execute all containers, redis, mysql and laravel.

![Docker containers](https://raw.githubusercontent.com/nicosli/Challenge-Senior-Backend-Developer/main/resources/images/docker_1.png)

An alias can be configured for more comfort
```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

For more details you can visit the official documentation:
https://laravel.com/docs/9.x/sail

Run this command to execute the migrations
```
sail artisan migrate
```

To save the data in the database run this commands
```
sail artisan UncompressFile
sail artisan XMLtoDataBase
sail artisan removeFile
```

## Tech Stack

- AWS EC2 t2.medium
- Laravel 9
- Mysql
- Redis 
- Docker (Sail)
- PHP 8.1
- Repo Github