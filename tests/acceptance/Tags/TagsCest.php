<?php
use \WebGuy;

class TagsCest
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
        $I->wantTo('Tags Crud');
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
    public function onTagsList(WebGuy $I) {
        $I->wantTo('Tags List');
        $I->amOnPage('/administration/tags/');
        $I->see("Liste des tags");
        $I->click('Créer un tag');

    }


    /**
     * On Tags Create
     * @before onTagsList
    */
    public function onTagsCreate(WebGuy $I) {
        $I->wantTo('Tags Creation');
        $I->amOnPage('/administration/tags/new');
//        $I->see("");
        $I->canSeeCurrentUrlEquals('/administration/tags/new');
        /*$I->submitForm('form#handletags',
            array(
                'word' => 'test alpha',
                'movies' => array(1,2)
            )); */

    }

    /**
     * On Tags Remove
     * @before onTagsCreate
    */
    public function onTagsRemove(WebGuy $I) {
        $I->wantTo('Tags Remove');
        $I->amOnPage('/administration/tags/');
        $I->see(" test alpha");
        $I->click("table > tbody > tr:nth-child(13) > td:nth-child(3) > a:nth-child(2)");
        $I->canSeeCurrentUrlEquals('/administration/tags/15/edit');
        $I->click("Delete");
        $I->see('Liste des tags');
        /*$I->submitForm('form#handletags',
            array(
                'word' => 'test alpha',
                'movies' => array(1,2)
            ));
*/
    }



}