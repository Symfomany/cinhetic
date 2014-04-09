<?php
use \WebGuy;

class CommentsCest
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
        $I->wantTo('Add Comment in Movies');
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
     * On Tags List
     * @before onHome
    */
    public function onCommentAdd(WebGuy $I) {
        $I->wantTo('Add Comment in Movies');
        $I->amOnPage('/administration/');
        $I->submitForm('#listmovies > div > div:nth-child(1) > div > div > form',
            array(
                'note' => 2,
                'content' => 'Un joli film!',
            ));
        $I->see('Votre commentaire a bien été ajouté');
        $I->see('Un joli film!');

    }




}