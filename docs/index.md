# Documentation

It is a documentation for PHP MVC Core

* [ Installation ](#installation)
    * [ Framework ](#install-framework)
    * [ Core ](#install-core)
* [ Configuration ](#configuration)
* [ Architecture ](#architecture)
    * [ index.php ](#indexphp)
    * [ Application ](#application)

## Installation

### Install framework

To install [ framework ](https://github.com/1mpossible-code/php-mvc-framework#installation)

* Download the archive or clone [ the project  ](https://github.com/1mpossible-code/php-mvc-framework) using git

```shell
git clone https://github.com/1mpossible-code/php-mvc-framework.git
```

* Create `.env` file from `.env.example` file
* Run `composer install`
* Run `docker-compose up`
* Open in browser http://localhost/

That's all steps to run the basic build of framework

### Install core

You can install the [ core ](https://github.com/1mpossible-code/php-mvc-core#installation) via composer

```shell
composer require impossible/php-mvc-core
```

## Configuration

Application passes config as a second argument. You can specify 'userClass' and 'db' sub-array to configure the
application

Basic config looks like:

```injectablephp
// index.php

$config = [
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];
```

Basic build uses [`vlucas/phpdotenv`](https://packagist.org/packages/vlucas/phpdotenv) package to extract `.env` file
parameters into `$_ENV` php variable

## Architecture

This section describes the framework and core components behavior

### index.php

[`index.php`][] contains the rules to control the application:

- You specify autoload
- You create an instance of Application
- You define routes
- Run application

### Application

[Application][] is a main class.

Application has properties:

Property | Definition
---------|-----------
request | Instance of [Request](#request)
response | Instance of [Response](#response)
session | Instance of [Session](#session)
router | Instance of [Router](#router)
view | Instance of [View](#view)
db | Instance of [Database](#database)
user | Instance of [User](#user)
controller | Instance of [Controller](#controller)
layout | Property that contains current layout
run() | Method that runs the application
login($user) | Method that login user to session
logout() | Method that logout user from session
getUser() | Method that returns user from session
isGuest() | Method that checks if current user is guest
triggerEvent($eventName) | Method that executes all registered callbacks for the given event
on($eventName, $callback) | Method that registers specified callback to specified event

[Request]: ../Request.php

[Response]: ../Response.php

[Session]: ../Session.php

[Router]: ../Router.php

[View]: ../View.php

[`index.php`]: https://github.com/1mpossible-code/php-mvc-framework/blob/master/public/index.php

[Application]: ../Application.php