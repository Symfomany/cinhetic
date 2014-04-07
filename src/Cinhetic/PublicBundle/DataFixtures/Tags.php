<?php
namespace Cinhetic\PublicBundle\DataFixtures;

use Cinhetic\PublicBundle\Entity\Categories;
use Cinhetic\PublicBundle\Entity\Movies;
use Cinhetic\PublicBundle\Entity\Tags;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadTagsData
 * @package Cinhetic\PublicBundle\Repository
 */
class LoadTagsData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $word = new Tags();
        $word->setWord("hobbit");

        $manager->persist($word);
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