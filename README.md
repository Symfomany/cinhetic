Cinhetic Project
========================

![Project Status](http://stillmaintained.com/lexik/LexikPayboxBundle.png)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Symfomany/cinhetic/badges/quality-score.png?s=e581977dbe520062202a5d26b7ffdc8d6ebf7393)](https://scrutinizer-ci.com/g/Symfomany/cinhetic/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5f2f2540-3843-4d77-8fce-ce8477a800f7/big.png)](https://insight.sensiolabs.com/projects/5f2f2540-3843-4d77-8fce-ce8477a800f7)

Welcome to the Cinhetic Project - a fully-functional application built in Symfony2
framework to learn this framework in 360° that you can use to handle **cinematographic world**!

Roadmap: Handle movies, categories of movies, tags of movies, actors, directors, cinemas, sessions, users, comments...

In some words: **Minimalist** features, **Collaborative** solution, **Pragmatic** and **Responsive** project


Demo
------------------
http://94.23.5.209/web/

```
Login: demo
Mdp: demo
```

Web App on Google Play
------------------
https://play.google.com/store/apps/details?id=com.cinhetic.cinhetic

Documentation
------------------
http://94.23.5.209/docs/


Documentation for training
------------
http://94.23.5.209/web/apprentissage


Requirements
------------

* PHP >=5.3.3
* PHPUnit ~ 3.7
* Elastic Search running
* PECL hash >= 1.1
* Fileinfo module
* openssl enabled


Screenshots
------------------


![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/MainScreen.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen3.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen4.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen5.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen6.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen8.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen9.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen10.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen11.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen14.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen7.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen12.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen15.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen16.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen17.png)




1) Installing the Cinhetic Standard Edition
----------------------------------

When it comes to installing the Cinhetic Project, you have the
following options.

### Use Composer (*recommended*)

As Symfony uses **Composer** to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the install from Composer:

    php composer.phar install


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
        "symfomany/cinhetic": "*"
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

### Enable routing

``` yaml
# app/config/routing.yml
CinheticPublicBundle:
    resource: "@CinheticPublicBundle/Resources/config/routing.yml"
```

Send Email in localhost
------------

### Add configure in parameters for send email in localhost

``` parameters.yml
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: julien@meetserious.com
    mailer_password: xxxxxxx
```

``` config.yml
swiftmailer:
   transport: gmail
   host:      smtp.gmail.com
   username:  "%mailer_user%"
   password:  "%mailer_password%"
   spool:     { type: memory }
```

And execute command line like:

```
    php app/console cinhetic:email email=julien@meetserious.com nom="Boyer Julien" message="Hello Ju!"
    or
    php app/console swiftmailer:email:send
```

### Refresh assets

``` bash
$ php app/console assets:install web/
```

### Installation of Elastic Search

``` bash
  cd ~
  sudo apt-get update
  sudo apt-get install openjdk-7-jre-headless -y

  ### Check http://www.elasticsearch.org/download/ for latest version of ElasticSearch and replace wget link below

  # NEW WAY / EASY WAY
  wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-1.1.0.deb
  sudo dpkg -i elasticsearch-1.1.0.deb

  # OLD WAY / HARD WAY
  wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-1.1.0.tar.gz
  tar -xf elasticsearch-1.1.0.tar.gz
  rm elasticsearch-1.1.0.tar.gz
  sudo mv elasticsearch-* elasticsearch
  sudo mv elasticsearch /usr/local/share

  curl -L http://github.com/elasticsearch/elasticsearch-servicewrapper/tarball/master | tar -xz
  sudo mv *servicewrapper*/service /usr/local/share/elasticsearch/bin/
  rm -Rf *servicewrapper*
  sudo /usr/local/share/elasticsearch/bin/service/elasticsearch install
  sudo ln -s `readlink -f /usr/local/share/elasticsearch/bin/service/elasticsearch` /usr/local/bin/rcelasticsearch

  sudo service elasticsearch start
  #curl http://localhost:9200
```


### Data fixtures (optional)

First, make sure that your db parameters are correctly set in `app/config/parameters.ini`.
You'll need to install ``Doctrine Data Fixtures`` (don't forget to add the
path to `AppKernel.php`) and then run:

``` bash
$ php app/console doctrine:fixtures:load
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

Chapters covered in project
---------------

* Installation & Configuration of Symfony2 Framework
* Multi-syntax in Yaml, Xml, PHP
* ClassLoader & PSR-0 & Composer Component
* Installation third bundles like FOSUserBundle, KNPPaginator...
* Routing layer
* Doctrine ORM & DQL
* Add Listener in security layer
* Console CLI Generators & configuration
* View: Twig Engine with inheritance, including, rendering, filters...
* Controllers: CRUD, Bind with Form/Entity, Entity Manager, HTTP Methods, Request object, Flash Message, services, redirection/forward
* Models: Annotations, Relationship (1:1;,1:n;n:m), Repositories, DQL
* Form: Types of fields, Dependancies with Model, Validations
* Refactoring code in Controllers & Repository with DRY Philosophy
* API Rest using Allocine V3 with Guzzle HTTP Framework
* Add custom command with console component
* Use SwiftMailer to send test email
* Add service with Service Container
* Implement payment solution in bundle
* Upload image in entity with Imagine library
* Embed form with Medias Videos for Movies (use Essence to display movies)



Features
----------------------------------
* Search Engine Movies
* Top Rated Movies
* Page Movie with complete description
* Visibility on Movies and cover action in homepage
* Pagination for results with "KNPPaginatorBundles"
* Datas Fixtures with "Doctrine Fixtures"
* Upload File Image in Movie with Imagine library for thumb
* Homepage with custom template by Bootsrapp Twitter
* Form & Repositories in services
* Add authentification & firewall administration for user connected with "FOSUserBundle"
* Rest API for Movies(CRUD) & Categories & Author & Directors with FOSRestBundle
* Page Category to list all movies related
* Page Tag to list movies related by keywords
* Page My Account related my informations
* View all comments by movies
* Add favorites movies in session
* Add optional node layers (socket.io) for comment
* Categories & Tags in cloud keywords
* Trailers of movies in slideshow
* Search engine in elastic search engine
* Comments by movies with forms
* API Rest using Allocine V3 with Guzzle HTTP Framework
* Ajax Search instant with Allocine API
* Add Email Decorator in service
* Add Pre-Order for Movies in Paybox with LexikPayboxBundle
* Embed form with Medias Videos use Essence for display
* Webapp released on Google Play

Evolution
----------------------------------
* Mongo for notifications & private message
* Node layer for notifications in real time
* Form & Controllers & Repositories in services
* Documentation by PHPDoc
* Advanced APIs for Mobiles Apps
* Acceptance tests with Codeception
* New design with Front-End/UX Developper @UnPetitLu https://twitter.com/UnPetitLu