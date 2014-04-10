<?php
namespace Cinhetic\PublicBundle\DataFixtures;

use Cinhetic\PublicBundle\Entity\Actors;
use Cinhetic\PublicBundle\Entity\Categories;
use Cinhetic\PublicBundle\Entity\Movies;
use Cinhetic\PublicBundle\Entity\Tags;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadActorsData
 * @package Cinhetic\PublicBundle\Repository
 */
class LoadActorsData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $word = new Actors();
        $word->setFirstname("Julien");
        $word->setLastname("Boyer");
        $word->setCity("Paris");
        $word->setDob(new \DateTime(('16/03/1988')));
        $word->setBiography("Symfony Developer");
        $word->setNationality("France");
        $word->setRecompenses("X");

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