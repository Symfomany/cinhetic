<?php
use \WebGuy;

class AuthentificateCest
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

    }

    /**
     * On Home
     * @param WebGuy $I
     */
    public function onFailureAuthentificate(WebGuy $I) {
        $I->wantTo('Fail to authentificate');
        $I->amOnPage('/login');
        $I->see('Authentification');
        $I->submitForm('form',
            array(
                '_username' => 'test@yahoo.fr',
                '_password' => 'ok',
            ));
        $errors = $I->grabTextFrom('.alert');
        $I->expect($errors);
    }

    /**
     * On Home
     * @param WebGuy $I
     */
    public function onSuccessAuthentificate(WebGuy $I) {
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



}