Cinhetic Standard Edition
========================

Welcome to the Cinhetic Standard Edition - a fully-functional Symfony2
application that you can use to handle all cinemas, actorsn directors...

Roadmap: handle movies, categories, tags, actors, directors, cinemas, sessions, users, comments...

Screenshots
------------------

![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/MainScreen.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen2.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen3.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen4.png)
![ScreenShot](https://raw.github.com/Symfomany/cinhetic/master/screenshots/Screen5.png)


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

Then, use the `create-project` command to generate a new Symfony application:

    php composer.phar create-project symfony/framework-standard-edition path/to/install


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