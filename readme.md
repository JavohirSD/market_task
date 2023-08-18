# Smartbazar API Challenge

Laravel v10.19.0 (PHP v8.1.5)

1. ```git clone https://github.com/JavohirSD/market_task.git```
2. ```composer install```
3. ```php artisan migrate```
3. ```php artisan optimize:clear```

### Running project tests
```php artisan test```

### Postman API Collection
https://documenter.getpostman.com/view/9645611/2s9Y5SVkgX

### Running project with Docker

For the first time it will take long time depending on your network speed and hardware (up to 10 minutes) to build all images.

1. ```git clone https://github.com/Laradock/laradock.git```


2. ```cp .env.example .env```


3. Change PHP_VERSION to 8.1

4. ```cd laradock```


Starting container


5. ```docker-compose up -d nginx mysql workspace ```



Get list of running containers:


```docker-compose ps```


Stop all containers:



6. ```docker-compose down```


Project will run in ```http://localhost```
