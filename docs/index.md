# Documentation

It is a documentation for PHP MVC Core

* [ Installation ](#installation)
    * [ Framework ](#install-framework)
    * [ Core ](#install-core)
* [ Configuration ](#configuration)
* [ Architecture ](#architecture)
    * [ Index ](#index)
    * [ Application ](#application)
    * [ Request ](#request)
    * [ Response ](#response)
    * [ Session ](#session)
    * [ Router ](#router)
    * [ Database ](#database)
    * [ View ](#view)
    * [ Migrations ](#migrations)

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

```php
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

### Index

[`index.php`][] contains the rules to control the application:

- You specify autoload
- You create an instance of Application
- You define routes
- Run application

### Application

[Application][] is a main class that controls all processes between

Application has:

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
ROOT_DIR | Static property that contains the root application path
app | Static property that contains an instance of [Application][]
run() | Method that runs the application
login($user) | Method that login user to session
logout() | Method that logout user from session
getUser() | Method that returns user from session
triggerEvent($eventName) | Method that executes all registered callbacks for the given event
on($eventName, $callback) | Method that registers specified callback to specified event
isGuest() | Static method that checks if current user is guest

## Request

[Request][] is a class that implements request logic in application

Request has:

Property | Definition
---------|-----------
getPath() | Get URI path
method() | Get current method of request
getBody() | Get sanitized data from request

## Response

[Response][] is a class that implements response logic

Response has:

Property | Definition
---------|-----------
redirect($url) | Redirect user to specified URL
setStatusCode($code) | Set response status code

## Session

[Session][] is a class that implements session logic

Session has:

Property | Definition
---------|-----------
set($key, $value) | Set key => value in session
get($key) | Get specified key
setFlash($key, $value) | Set specified session flash message
getFlash($key) | Get specified session flash message
hasFlash($key) | Check if the flash message with specified key is exists
remove($key) | Remove the given key from session

## Router

[Router][] is a class that implements application routing

Router has:

Property | Definition
---------|-----------
request | Instance of [Request](#request)
response | Instance of [Response](#response)
get($path, $callback) | Create new 'get' route
post($path, $callback) | Create new 'post' route
resolve() | Process request data to return valid result of routing logic

## Database

[Database][] is a class that controls different database processes

Database has:

Property | Definition
---------|-----------
PDO | Instance of [PDO](https://www.php.net/manual/book.pdo.php)
prepare($SQL) | Prepare SQL statement
applyMigrations() | Apply new [migrations][]
saveMigrations($migrations) | Save migration names from given array to migrations table
createMigrationsTable() | Create migrations table if not already exists
getAppliedMigrations() | Get already applied migrations

## View

[View] is a class that implements view system

You can access view class through `$this` in views

View has:

Property | Definition
---------|-----------
title | Page title
renderView($view) | Render specified view
renderContent($content) | Render content data directly to layout

## Migrations

[`migrations.php`][] is a file that controls migration logic.

To execute migrations make:

```shell
php migrations.php
```

To create new migration just implement [MigrationInterface](../MigrationInterface.php)

> You can use [Application][] db property to control database

Example of migration can find
with [the link](https://github.com/1mpossible-code/php-mvc-framework/blob/master/migrations/m0001_create_users_table.php)

[Application]: ../Application.php

[Request]: ../Request.php

[Response]: ../Response.php

[Session]: ../Session.php

[Router]: ../Router.php

[View]: ../View.php

[Database]: ../Database.php

[`index.php`]: https://github.com/1mpossible-code/php-mvc-framework/blob/master/public/index.php

[`migrations.php`]: https://github.com/1mpossible-code/php-mvc-framework/blob/master/migrations.php

[migrations]: #migrations