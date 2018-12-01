Cocktail Manager
================

COCKTAIL<b>MANAGER</b> is a simple Symfony 3.4 application for managing cocktails. 
<br>
- Anyone on the site is able to view existing cocktails and ingredients. 
- Only registered users are able to add new, edit and delete existing cocktails.

To install the application, follow these steps:
- Clone the repository with `git clone https://github.com/filip-polic/cocktail-manager.git`
- Switch into project folder with `cd cocktail-manager`
- Install dependencies with composer `composer install`
- Update database schema with `php bin/console doctrine:schema:update --force` 
or import the database from `_SQL` folder into your phpMyAdmin
- Run the server `php bin/console server:run`

<img src="https://filippolic.from.hr/assets/img/content/cocktail-manager.png"/>