Cinhetic Standard Edition
========================

Welcome to the Cinhetic Standard Edition - a fully-functional Symfony2
application that you can use to handle **all cinematographic world**!

Roadmap: handle movies, categories, tags, actors, directors, cinemas, sessions, users, comments...

Philosophy: **Minimalist** features, **Collaborative** in real time, **Maintainable**, **Pragmatic** and **Responsive** Solution.

Screenshots
------------------

![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/MainScreen.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen3.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen4.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen5.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen6.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen7.png)


1) Installing the Cinhetic Standard Edition
----------------------------------

When it comes to installing the Cinhetic Standard Edition, you have the
following options.

### Use Composer (*recommended*)

As Symfony uses [Composer][2] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the install from Composer:

    php composer.phar install

```

Quick Installation
------------------

``` bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar create-project Symfomany/Cinhetic -s dev
$ cd Cinhetic
$ php app/console Cinhetic:install


Installation
------------

### Add the deps for the needed bundles

``` php
[CinheticPublicBundle]
    git=https://github.com/Symfomany/Cinhetic.git
    target=/bundles/cinhetic/

```
Or add CinheticPublicBundle in your composer.json

```js
{
    "require": {
        "Symfomany/cinhetic": "*"
    }
}
```
If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

```bash
    curl -s https://getcomposer.org/installer | php
```

Next, run the vendors script to download the bundles:

``` bash
$ php bin/vendors install
```

### Add to autoload.php

``` php
$loader->registerNamespaces(array(
    'Cinhetic'             => __DIR__.'/../vendor/bundles',
    // ...
```
### Register CinheticPublicBundle to Kernel

``` php
<?php

    # app/AppKernel.php
    //...
    $bundles = array(
        //...
        new Cinhetic\Public\CinheticPublicBundle(),
    );
    //...
```

### Create database and schema

``` bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

### Enable routing configuration

``` yaml
# app/config/routing.yml
CinheticPublicBundle:
    resource: "@CinheticPublicBundle/Resources/config/routing.yml"
```
### Refresh asset folder

``` bash
$ php app/console assets:install web/
```


### Data fixtures (optional)

First, make sure that your db parameters are correctly set in `app/config/parameters.ini`.
You'll need to install ``Doctrine Data Fixtures`` (don't forget to add the
path to `AppKernel.php`) and then run:

``` bash
$ php app/console doctrine:fixtures:load

You can read about install instructions in the Symfony2 Cookbook(http://symfony.com/doc/2.0/cookbook/doctrine/doctrine_fixtures.html#setup-and-configuration)
```



Run Tests Codeception
------------------
``` bash
bin/codecept run --html --colors --report --steps
```

Optional Requirements
---------------

* Mongo DB
* Elastic Search
* Node JS
* Composer
* Symfony 2

2) Features
----------------------------------
* Search by Cities in sessions of cinemas
* Best Movies by rating
* Add pagination for results
*
* Add press comments in Movies
* Homepage with custom template
* Movies in weeks
* Add Authentification for User Connect with FOS
* Print my Billet with QRCode & TCPDF
* Page Category listing all movies related
* Page Keywords listing all movies related
* Page Films Favorites by User connected
* View all comments by Movies
* Search in ajax & instant search
* Add slideshow to presentation in homepage
* Add in session favorites and billeterie
* Add Player for video in medias
* Add upload in Medias in ajax with uploadify
* Add Node Layers for comments
* Add scoring with JRate
* Movies more scored
* Categories in cloud tags
* Tags in clud tags
* Trailers in slideshow
* Handle Distributions from Movies
* Handle Medias for Movies
* Search Engin in Elastic Search
* Page Film Unit
* Comments by Movies
* Number Movies, Categories, Tags...


3) Evolution
----------------------------------
* Mongo for Notifications
* Add Datas Fixtures with Doctrine
* Add APIS for Mobiles