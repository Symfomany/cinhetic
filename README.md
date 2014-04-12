Cinhetic Project
========================

Welcome to the Cinhetic Project - a fully-functional application built in Symfony2
framework for learning this framework in 360° that you can use to handle **cinematographic world**!

Roadmap: Handle movies, categories of movies, tags of movies, actors, directors, cinemas, sessions, users, comments...

In some words: **Minimalist** features, **Collaborative** solution, **Pragmatic** and **Responsive** project


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
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen7.png)


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
* Console CLI Generators & configuration
* View: Twig Engine with inheritance, including, rendering, filters...
* Controllers: CRUD, Bind with Form/Entity, Entity Manager, HTTP Methods, Request object, Flash Message, services, redirection/forward
* Models: Annotations, Relationship (1:1;,1:n;n:m), Repositories, DQL
* Form: Types of fields, Dependancies with Model, Validations


2) Features
----------------------------------
* Search Engine Movies
* Top Rated Movies
* Page Movie with complete description
* Pagination for results with "KNPPaginatorBundles"
* Datas Fixtures with "Doctrine Fixtures"
* Homepage with custom template by Bootsrapp Twitter
* Add authentification & firewall administration for user connected with "FOSUserBundle"
* Rest API for Movies(CRUD) with FOSRestBundle
* Page Category to list all movies related
* Page Tag to list movies related by keywords
* Page "Favorites Movies" by user connected
* Page My Account related my informations
* View all comments by movies
* Add in session favorites movies
* Add optional node layers (socket.io) for comment
* Categories & Tags in cloud keywords
* Trailers of movies in slideshow
* Search engine in elastic search engine
* Comments by movies with forms


3) Evolution
----------------------------------
* Mongo for notifications & private message
* Form & Controllers & Repositories in services
* Documentation by PHPDoc
* Advanced APIs for Mobiles Apps
* Acceptance tests with Codeception