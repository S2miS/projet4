<h2>Description :</h2>

This site was made for my studies, it's a ticket office for the Louvre museum developed under Symfony. 


<h2>Features :</h2>

- Footer with link to the official Louvre site and to the general conditions of sale
- Homepage with link to the ticketing system as well as opening hours and museum prices
- Page "Votre Commande" where you choose the visit day, the ticket type, the ticket number and your email
- Page "Vos billets" where you add personal information (First name, last name, birthday, country)
- Page "Résumé" gives you a global view of the order as well as a link to the payment system managed by Stripe
 

<h2>Required :</h2>

- PHP 7.2+
- MySQL Database
- Apache Server
- Symfony 4
- Composer
- Stripe
- SwiftMailer

<h2>How to install ? :</h2>

First download the site on GitHub here : https://github.com/S2miS/projet4.git<br>
Then install the site on your server<br>
Don't forget to install Composer (https://github.com/composer/composer), Symfony (https://symfony.com), SwiftMailer 
(https://symfony.com/doc/current/email.html) and Stripe (https://stripe.com/docs)<br>
Command : `composer install`<br>
For the Database, use the code below :

Command : `bin/console doctrine:migration:migrate`<br>


Usage
-----

There's no need to configure anything to run the application. If you have
installed the [Symfony client][4] binary, run this command to run the built-in
web server and access the application in your browser at <http://localhost:8000>:

```bash
$ cd projet4/
$ bin/console server:run
```

If you don't have the Symfony client installed, run `php bin/console server:run`.
Alternatively, you can [configure a web server][3] like Nginx or Apache to run
the application.

Tests
-----

Execute this command to run tests:

```bash
$ cd projet4/
$ ./bin/phpunit
```
