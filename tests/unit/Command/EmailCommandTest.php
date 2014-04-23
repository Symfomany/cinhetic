<?php
use Codeception\Util\Stub;
use \Symfony\Component\Console\Application;
use \Cinhetic\PublicBundle\Command\EmailCommand;

class EmailCommandTest extends \Codeception\TestCase\Test
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
     * test Execute method
     */
    public function testExecute()
    {
        $kernel = $this->getModule('Symfony2')->container->get('kernel');

//        $kernel = $kernel->createKernel();
//        $kernel->boot();
//
//        $application = new Application($kernel);
//        $application->add(new EmailCommand());
//
//        $command = $application->find('cinhetic:email');
//        $commandTester = new \Symfony\Component\Console\Tester\CommandTester($command);
//        $commandTester->execute(array('email' => "julien@meetserious.com"));
    }

}