<?php
use Codeception\Util\Stub;
use Lexik\Bundle\PayboxBundle\Event\PayboxResponseEvent;

class EmailTest extends \Codeception\TestCase\Test
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
     * test Send method
     */
    public function testSend()
    {
        $container = $this->getModule('Symfony2')->container;
        $email = $container->get('cinhetic_public.email');
        $email->send("zuzu38080@gmail.com", 'CinheticPublicBundle:Email:welcome.html.twig', 'Email de test', 'julien@meetserious.com');

    }

}