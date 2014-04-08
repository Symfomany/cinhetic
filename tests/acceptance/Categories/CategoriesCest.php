<?php
use \WebGuy;

class CategoriesCest
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
        $I->wantTo('Categories Crud');
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
     * On Categories List
     * @before onHome
    */
    public function onCategoriesList(WebGuy $I) {
        $I->wantTo('Categories List');
        $I->amOnPage('/administration/categories/');
        $I->see("Liste des categories");
        $I->click('Creation de la catégorie');
        $I->see("Création de la Categories");

    }


    /**
     * On Categories Create
     * @before onCategoriesList
    */
    public function onCategoriesCreate(WebGuy $I) {

        $I->submitForm('form#handlecategorie',
            array(
                'title' => 'Ici',
                'description' => 'Blabla...',
            ));
        $I->see('Voir la catégorie');

    }


    /**
     * On Categories Create
     * @before onCategoriesList
    */
    public function onCategoriesEdit(WebGuy $I) {
        $I->amOnPage('/administration/categories/');
        $I->see("Aventure");
        $I->click('table > tbody > tr:nth-child(9) > td:nth-child(5) > a:nth-child(2)');
        $I->seeCurrentUrlEquals('/administration/categories/9/edit');

        $I->submitForm('form#handlecategorie',
            array(
                'title' => 'Aventures et Actions',
                'description' => "Film d'aventures et d'actions",
            ));
        //$I->see('Liste des categories');
    }



    /**
     * On Categories Create
     * @before onCategoriesList
    */
    public function onCategoriesDelete(WebGuy $I) {
        $I->amOnPage('/administration/categories/');
        $I->see("Aventure");
        $I->click('table > tbody > tr:nth-child(11) > td:nth-child(5) > a:nth-child(2)');
        $I->click('Delete');
    }



}