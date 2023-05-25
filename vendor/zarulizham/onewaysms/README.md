# OneWaySMS Laravel Package


## Installation 
***
You can pull in the package via composer:
```
composer require zarulizham/OneWaySMS
```

### Installation (Laravel 5.5 and below)

Then add this line to `config/app.php` in `providers`
```
OneWaySMS\SmsServiceProvider::class,
```

Store username and password credentials in `.env` or simply put in `make()` (see example below)

### Additional .env attributes
```
ONEWAY_USERNAME=
ONEWAY_PASSWORD=
```

## Usage
***

### Example 1
```php
use OneWaySMS\SMS

SMS::to("0123456789")->message("Hello there!")->send();

```
There is no need to use make() if credential stored in `.env`

### Example 2
```php
use OneWaySMS\SMS

SMS::make([
    'username' => 'yourusernamehere',
    'password' => 'yourpasswordhere',
])->to("0123456789")->message("Hello there!")->send();

```
