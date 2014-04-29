<?php
use Codeception\Util\Stub;

class CinemasRepositoryTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    /**
     * Befor Hook
     */
    protected function _before()
    {
    }

    /**
     * After Hook
     */
    protected function _after()
    {
    }

    /**
     * test GetCurrentMovies method
     */
    public function testGetCitiesOfMovies()
    {
        $container = $this->getModule('Symfony2')->container;
        $em = $container->get('doctrine')->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Cinema')->getCitiesOfMovies();
        $this->assertEquals(5, count($movies));
    }

}