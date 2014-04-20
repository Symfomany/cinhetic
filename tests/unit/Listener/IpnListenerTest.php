<?php
use Codeception\Util\Stub;
use Lexik\Bundle\PayboxBundle\Event\PayboxResponseEvent;

class IpnListenerTest extends \Codeception\TestCase\Test
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
    public function testOnPayboxIpnResponse()
    {
        $container = $this->getModule('Symfony2')->container;
        $listener = $container->get('cinhetic_public.paybox.response_listener');
        $event = new PayboxResponseEvent(array('message' => 'success'), true);
        $listener->onPayboxIpnResponse($event);

    }

}