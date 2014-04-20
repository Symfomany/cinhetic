<?php
use Codeception\Util\Stub;

class SessionsRepositoryTest extends \Codeception\TestCase\Test
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
     * test getNextSessions method
     */
    public function testGetNextSessions()
    {
        $container = $this->getModule('Symfony2')->container;
        $em = $container->get('doctrine')->getManager();
        $sessions = $em->getRepository('CinheticPublicBundle:Sessions')->getNextSessions(5);
        $this->assertEquals(3, count($sessions));
    }

}