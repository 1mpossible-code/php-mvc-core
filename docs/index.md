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
    * [ Controller ](#controller)
    * [ Model ](#model)
    * [ DbModel ](#dbmodel)
* [ User ](#user)
* [ Exceptions ](#exceptions)
* [ Middlewares ](#middlewares)
* [ Form Widget ](#form-widget)
* [ Migrations ](#migrations)

## Installation

### Install framework

To install [ framework ](https://github.com/1mpossible-code/php-mvc-framework#installation)

* Download the archive or clone [ the project  ](https://github.com/1mpossible-code/php-mvc-framework) using git:

```shell
git clone https://github.com/1mpossible-code/php-mvc-framework.git
```

* Create `.env` file from `.env.example` file
* Run `composer install`
* Run `docker-compose up`
* Open in browser http://localhost/

That's all steps to run the basic build of framework.

### Install core

You can install the [ core ](https://github.com/1mpossible-code/php-mvc-core#installation) via composer

```shell
composer require impossible/php-mvc-core
```

## Configuration

[ Application ](#application) passes config as a second argument. You can specify 'userClass' and 'db' sub-array to
configure the application.

Basic config looks
like ([index.php](https://github.com/1mpossible-code/php-mvc-framework/blob/master/public/index.php)):

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
parameters into `$_ENV` php variable.

## Architecture

This section describes the framework and core components behavior.

### Index

[`index.php`](https://github.com/1mpossible-code/php-mvc-framework/blob/master/public/index.php) contains the rules to
control the application:

- You specify autoload;
- You create an instance of [ Application ](#application);
- You define routes;
- Run application.

----

### Application

[Application](../Application.php) is a main class that controls all processes between

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
app | Static property that contains an instance of [Application](../Application.php).
run() | Method that runs the application
login($user) | Method that login [ user ](#user) to session
logout() | Method that logout [ user ](#user) from session
getUser() | Method that returns [ user ](#user) from session
triggerEvent($eventName) | Method that executes all registered callbacks for the given event
on($eventName, $callback) | Method that registers specified callback to specified event
isGuest() | Static method that checks if current [ user ](#user) is guest

----

### Request

[Request](../Request.php) is a class that implements request logic in application

Request has:

Property | Definition
---------|-----------
getPath() | Get URI path
method() | Get current method of request
getBody() | Get sanitized data from request

----

### Response

[Response](#response) is a class that implements response logic

Response has:

Property | Definition
---------|-----------
redirect($url) | Redirect [ user ](#user) to specified URL
setStatusCode($code) | Set response status code

----

### Session

[Session](../Session.php) is a class that implements session logic

Session has:

Property | Definition
---------|-----------
set($key, $value) | Set key => value in session
get($key) | Get specified key
setFlash($key, $value) | Set specified session flash message
getFlash($key) | Get specified session flash message
hasFlash($key) | Check if the flash message with specified key is exists
remove($key) | Remove the given key from session

----

### Router

* [Define](#define-new-route)

[Router](../Router.php) is a class that implements application routing

Router has:

Property | Definition
---------|-----------
request | Instance of [Request](#request)
response | Instance of [Response](#response)
get($path, $callback) | Create new 'get' route
post($path, $callback) | Create new 'post' route
resolve() | Process request data to return valid result of routing logic

#### Define new route

You can define routes in [`index.php`](#index) file through [Application](#application):

```php
// index.php

/** @var \impossible\phpmvc\Application $app */

// Controller's index method
$app->router->get('/',[\impossible\phpmvc\Controller::class, 'index']);
// Render view with the name 'view'
$app->router->get('/', 'view');
// Render plain text
$app->router->get('/', function () {
    return 'plain text';
});
```

You can see examples
with [ the link ](https://github.com/1mpossible-code/php-mvc-framework/blob/master/public/index.php)

----

### Database

[Database](../Database.php) is a class that controls different database processes

Database has:

Property | Definition
---------|-----------
PDO | Instance of [PDO](https://www.php.net/manual/book.pdo.php)
prepare($SQL) | Prepare SQL statement
applyMigrations() | Apply new [migrations](#migrations)
saveMigrations($migrations) | Save [ migration ](#migrations) names from given array to migrations table
createMigrationsTable() | Create [ migrations ](#migrations) table if not already exists
getAppliedMigrations() | Get already applied [ migrations ](#migrations)

----

### View

* [Create view](#create-new-view)
* [Create layout](#create-new-layout)

[View](../View.php) is a class that implements view system

You can access view class through `$this`
in [ views ](https://github.com/1mpossible-code/php-mvc-framework/tree/master/views)

View has:

Property | Definition
---------|-----------
title | Page title
renderView($view) | Render specified view
renderContent($content) | Render content data directly to layout

#### Create new view

To create new view you must create a php file with view name
in [ views folder ](https://github.com/1mpossible-code/php-mvc-framework/tree/master/views) in the root directory
of [ Application ](#application)

> You may specify the title in the php tag with the help of `$this`

You can see an example
with [ the link ](https://github.com/1mpossible-code/php-mvc-framework/blob/master/views/home.php)

#### Create new layout

To create new layout you must create a php file with layout name
in [ layout folder ](https://github.com/1mpossible-code/php-mvc-framework/tree/master/views/layouts) in
the [ views folder ](https://github.com/1mpossible-code/php-mvc-framework/tree/master/views).

You **MUST** create a {{content}} placeholder to specify where content will be rendered

> You may access `$this` in layout, for example, to echo title

You can see an example
with [ the link ](https://github.com/1mpossible-code/php-mvc-framework/blob/master/views/layouts/main.php)

----

### Controller

* [Create](#create-new-controller)
* [Usage](#usage-of-controller)
* [Middlewares](#middlewares-in-controller)

[Controller](#controller) is a base class that should be used with developers to implement logic.

Controller has:

Property | Definition
---------|-----------
layout | Contains current layout. Default: 'main'
action | Contains current action
render($view, $params) | Render specified view with the given params
setLayout($layout) | Set layout property
registerMiddleware($middleware) | Register new [middleware](#middlewares)
getMiddlewares() | Get all registered [middlewares](#middlewares)

#### Create new controller

To create new **controller** implement base [Controller](../Controller.php) class and create action(s) in
it. [ Example ](https://github.com/1mpossible-code/php-mvc-framework/blob/master/controllers/ContactController.php)

#### Usage of controller

You may pass controller and action to [ route ](#define-new-route) array in [index.php](#index):

```php
/** @var \impossible\phpmvc\Application $app */
// Controller is the first parameter and name of the action as a second
$app->router->get('/',[\impossible\phpmvc\Controller::class, 'index']);
```

#### Middlewares in controller

To specify new [ middleware ](#middlewares) in controller:

- [Create new middleware](#create-new-middleware) or use [ existing one ](../middlewares);
- Specify it in controller constructor with the help of `registerMiddleware($middleware)` method.

You can see an example of using middlewares
with [the link](https://github.com/1mpossible-code/php-mvc-framework/blob/master/controllers/ProfileController.php)

----

### Model

* [Rules](#model-rules)
* [Create](#create-new-model)

[Model](../Model.php) is a class that works with data.

Model has:

Property | Definition
---------|-----------
loadData($data) | Load data on Model ( $key => $value ).
rules() | Get [ rules ](#model-rules) for validation. Must be implemented to control validation.
validate() | Validate attributes with already created [rules](#model-rules).
getLabel($attribute) | Get label for given attribute.
labels() | Get labels. May be rewritten to specify labels.
addError($attribute, $message) | Add new error for the given attribute.
hasError($attribute) | Check if the attribute has an error.
getFirstError($attribute) | Get first error for specified attribute.
errorMessages() | Get error messages for [rules](#model-rules).
errors() | Get errors array.

#### Model rules

Model has rules:

Property | Definition
---------|-----------
RULE_REQUIRED | Checks if the data must be required.
RULE_EMAIL | Checks if the data must be email.
RULE_MIN | Checks if the data must be more than min value. Must be used in array with the second named element 'min' to define the minimum value.
RULE_MAX | Checks if the data must be less then max value. Must be used in array with the second named element 'max' to define the maximum value.
RULE_MATCH | Checks if the data must be the same as another field. Must be used in array with the second named element 'match' to define the element it must matches with.
RULE_UNIQUE | Checks if the data must be unique for specified database model class. Must be used in array with the second named element 'class' to define the class in what data must be unique. May contain the third named element 'attribute' if must be unique with another attribute.

#### Create new Model

To create new model, implement [Model](../Model.php) or [DbModel](#dbmodel) class

[ Example of Model class ](https://github.com/1mpossible-code/php-mvc-framework/blob/master/models/LoginForm.php)

----

### DbModel

[DbModel](../DbModel.php) is an extended class with features to control database that implements [Model](#model).

Each [DbModel](../DbModel.php) class has its own table and:

Property | Definition
---------|-----------
tableName() | Table that belongs to this [DbModel](../DbModel.php).
primaryKey() | Primary key of the model.
attributes() | Attributes that will be saved to database.
save() | Save attributes to database.
findOne($where) | Static method that finds one model record from database with $where parameters.
prepare($SQL) | Static method that prepares SQL statements

## User

* [Create](#create-new-user)

User is an implementation of [DbModel](#dbmodel).

It is a class that referred to people who use application. This class must be [ specified ](#configuration)
in `$config['userClass']` variable.

It has 2 logic methods: `login($user)` and `logout()` in [ Application ](#application).

### Create new user

To create a user implement [DbModel](#dbmodel) and pass the class to [ config ](#configuration).

To see an example follow [the link](https://github.com/1mpossible-code/php-mvc-framework/blob/master/models/User.php)

## Exceptions

* [Create](#create-new-exception)

[ Exceptions ](../exception) is a classes that implements [`\Exception`](https://www.php.net/manual/class.exception.php)
.

> Exceptions are rendered through [ _error view ](https://github.com/1mpossible-code/php-mvc-framework/blob/master/views/_error.php)

### Create new exception

To create new exception extend the [Exception](https://www.php.net/manual/class.exception.php) class and specify `$code`
and `$message` at least.

To see an example follow [the link](../exception/NotFoundException.php)

## Middlewares

* [Create](#create-new-middleware)

Middlewares is a class that controls the authorization of actions in [ controllers ](#middlewares-in-controller).

Middleware has an `execute()` method that implements the logic of component (throws exceptions etc.).

### Create new middleware

To create new middleware extend base [Middleware](../middlewares/Middleware.php) and implement `execute()` method.

To see an example follow [the link](../middlewares/AuthMiddleware.php)

## Form Widget

* [Form Elements](#form-elements)
* [Make form](#make-form)

[ Form Widget ](../form/Form.php) is a class that makes creating forms easy and powerful

Form has:

Property | Definition
---------|-----------
field($formElement, $model, $attribute) | Render new field with specified [ FormElement ](#form-elements), [Model](#model) and attribute name.
submit() | Render submit button.
end() | End form widget.

### Form Elements

[ Form elements ](../form/elements) are components that implements [ FormElement ](../form/FormElement.php) interface

### Make form

To create new form you need:

- Create an instance of [Form](../form/Form.php) in [ view ](#view) with action and method:

```html
<?php $form = new Form('/contact', 'POST') ?>
```

- Create new field(s) with [ form elements ](../form/elements)

```html
<?php $form->field(InputText::class, $model, 'subject') ?>
```

- Create submit button and end form:

```html
<?php $form->submit(); ?>
<?php $form->end(); ?>
```

You can see an example of usage Form Widget
with [the link](https://github.com/1mpossible-code/php-mvc-framework/blob/master/views/contact.php)

## Migrations

* [Create](#create-new-migration)

[`migrations.php`](https://github.com/1mpossible-code/php-mvc-framework/blob/master/migrations.php) is a file that
controls migration logic.

To execute migrations make:

```shell
php migrations.php
```

> You can use [Application](#application) db property to control database

### Create new migration

To create new migration just implement [MigrationInterface](../MigrationInterface.php)

Example of migration can be found
with [the link](https://github.com/1mpossible-code/php-mvc-framework/blob/master/migrations/m0001_create_users_table.php)

---

All rights are reserved. Copyright © 2021 [1mpossible-code](https://github.com/1mpossible-code).

This project is [GPLv3](https://www.https://www.gnu.org/licenses/gpl-3.0.htmlgnu.org/licenses/gpl-3.0) licensed.