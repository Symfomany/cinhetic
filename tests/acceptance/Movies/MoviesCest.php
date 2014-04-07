<?php
use \WebGuy;

class MoviesCest
{

    public function _before()
    {
    }

    public function _after()
    {
    }

    /**
     * On Home
     * @param WebGuy $I
     */
    public function onHome(WebGuy $I) {
        $I->wantTo('Movies Crud');
        $I->amOnPage('/administration');
        $I->see('Authentification');
        $I->see('Se souvenir de moi');

        $I->wantTo('Success to authentificate');
        $I->amOnPage('/login');
        $I->see('Authentification');
        $I->submitForm('form',
            array(
                '_username' => 'julien',
                '_password' => 'djscrave',
            ));
        $I->see("Films à l'affiche");

    }


    /**
     * On Movies List
     * @before onHome
    */
    public function onMoviesList(WebGuy $I) {
        $I->wantTo('Movies List');
        $I->amOnPage('/administration/movies/');
        $I->see("Liste des Films");
        $I->click('Création de film');
        $I->see("Création de film");

    }


    /**
     * On Movies Create
     * @before onMoviesList
    */
    public function onMoviesCreate(WebGuy $I) {
        $I->wantTo('Movies Creation');
        $I->see("Création de film");
        $I->submitForm('form#handlemovie',
            array(
                'title' => 'okayyyy',
                'typeFilm' => 'Moyen-Metrage',
                'synopsis' => 'laaaa',
                'trailer' => '<iframe width="560" height="315" src="//www.youtube.com/embed/w8GG_Mp27gk" frameborder="0" allowfullscreen></iframe>',
                'description' => 'looooooool',
                'languages' => 'fr',
                'bo' => 'VOST',
                'category' => 1,
                'actors' => array(1,2),
                'cinemas' => array(3,4,5),
                'directors' => array(1),
                'moviesRelated' => array(2),
                'tags' => array(2,4,6),
                'distributeur' => 'Paramont',
                'annee' => 2014,
                'budget' => 152365477,
                'duree' => 1.52,
                'notePresse' => 3.5,
                'visible' => true,
                'cover' => true,
            ));
        $I->see('Le film');

    }



}