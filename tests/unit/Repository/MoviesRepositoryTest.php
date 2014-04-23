<?php
use Codeception\Util\Stub;

class MoviesRepositoryTest extends \Codeception\TestCase\Test
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
    public function testGetCurrentMovies()
    {
        $container = $this->getModule('Symfony2')->container;
        $em = $container->get('doctrine')->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getCurrentMovies();
        $this->assertEquals(1, count($movies));
    }

    /**
     * test Search method
     */
    public function testSearch()
    {
        $container = $this->getModule('Symfony2')->container;
        $em = $container->get('doctrine')->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->search('Hobbit');
        $this->assertEquals(2, count($movies));

        $movie = $em->getRepository('CinheticPublicBundle:Movies')->search('Frodon Sacquet');
        $this->assertEquals(1, count($movie));

        $movie = $em->getRepository('CinheticPublicBundle:Movies')->search('coucou');
        $this->assertEquals(0, count($movie));

    }

    /**
     * test GetMoviesByCity method
     */
    public function testGetMoviesByCity()
    {
        $container = $this->getModule('Symfony2')->container;
        $em = $container->get('doctrine')->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getMoviesByCity('Paris');
        $this->assertEquals(0, count($movies));

        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getMoviesByCity('Paris 2eme');
        $this->assertEquals(1, count($movies));
    }

    /**
     * test GetAllMovies method
     */
    public function testGetAllMovies()
    {
        $container = $this->getModule('Symfony2')->container;
        $em = $container->get('doctrine')->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getAllMovies(1);
        $this->assertEquals(1, count($movies));

    }

    /**
     * test GetAllMovies method
     */
    public function testGetCoverMovies()
    {
        $container = $this->getModule('Symfony2')->container;
        $em = $container->get('doctrine')->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getCoverMovies();
        $this->assertEquals(2, count($movies));
    }

}