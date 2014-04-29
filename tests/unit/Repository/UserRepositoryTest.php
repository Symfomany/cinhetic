<?php
use Codeception\Util\Stub;

class UserRepositoryTest extends \Codeception\TestCase\Test
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
     * test getActiveUserQueryBuilder method
     */
    public function testGetActiveUserQueryBuilder()
    {
        $container = $this->getModule('Symfony2')->container;
        $em = $container->get('doctrine')->getManager();
        $users = $em->getRepository('CinheticPublicBundle:User')->getActiveUserQueryBuilder();
        $this->assertEquals(1, count($users));
    }

}