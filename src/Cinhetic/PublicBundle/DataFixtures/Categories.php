<?php
namespace Cinhetic\PublicBundle\DataFixtures;

use Cinhetic\PublicBundle\Entity\Categories;
use Cinhetic\PublicBundle\Entity\Movies;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCategoriesData
 * @package Cinhetic\PublicBundle\Repository
 */
class LoadCategoriesData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $category = new Categories();
        $category->setTitle("Autobiographie");
        $category->setDescription("Film autobiographique français");

        $manager->persist($category);
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

}