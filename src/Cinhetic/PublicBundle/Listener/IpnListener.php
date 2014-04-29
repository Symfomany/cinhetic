<?php

namespace Cinhetic\PublicBundle\Listener;

use Symfony\Component\Filesystem\Filesystem;

use Lexik\Bundle\PayboxBundle\Event\PayboxResponseEvent;

/**
 * Class IpnListener
 * @package Cinhetic\PublicBundle\Listener
 */
class IpnListener
{
    /**
     * @var string
     * Directory root
     */
    private $rootDir;

    /**
     * @var Filesystem
     * filesystem of Symfony2
     */
    private $filesystem;

    /**
     * Constructor.
     * @param string     $rootDir
     * @param Filesystem $filesystem
     */
    public function __construct($rootDir, Filesystem $filesystem)
    {
        $this->rootDir = $rootDir;
        $this->filesystem = $filesystem;
    }

    /**
     * Creates a txt file containing all parameters for each IPN.
     * @param PayboxResponseEvent $event
     */
    public function onPayboxIpnResponse(PayboxResponseEvent $event)
    {
        $path = sprintf('%s/../data/%s', $this->rootDir, date('Y\/m\/d\/'));
        $this->filesystem->mkdir($path);

        $content = sprintf('Signature verification : %s%s', $event->isVerified() ? 'OK' : 'KO', PHP_EOL);
        foreach ($event->getData() as $key => $value) {
            $content .= sprintf("%s:%s%s", $key, $value, PHP_EOL);
        }

        file_put_contents(
            sprintf('%s%s.txt', $path, time()),
            $content
        );
    }
}