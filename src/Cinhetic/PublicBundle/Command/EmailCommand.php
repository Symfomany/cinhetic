<?php

namespace Cinhetic\PublicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EmailCommand
 * @package Cinhetic\PublicBundle\Command
 */
class EmailCommand extends ContainerAwareCommand
{

    /**
     * Configure email in CLI
     */

    protected function configure()
    {
        $this->setName('cinhetic:email')
            ->setDescription("Test d'envoi de d'email avec SwiftMailer et Console")
            ->addArgument('email',InputArgument::OPTIONAL,'Quel email voulez-vous spammer?')
            ->addArgument('nom',InputArgument::OPTIONAL,'Quel nom voulez-vous spammer?')
            ->addArgument('message',InputArgument::OPTIONAL,'Quel message voulez-vous?')
            ->setHelp(<<<EOT
The <info>4sq:checkins</info> command send test email with email nom message
EOT
            );
    }


    /**
     * Execute command line
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $nom = $input->getArgument('nom');
        $message = $input->getArgument('message');
        if($email){

            //Send email with SwiftMailer
            $message = \Swift_Message::newInstance()
                ->setSubject('Email de test venant de Cinhetic Project')
                ->setFrom('julien@meetserious.com')
                ->setTo($email)
                ->setBody($this->getContainer()->get('templating')->render('CinheticPublicBundle:Email:test.html.twig',
                    array(
                        'nom' => $nom,
                        'message' => $message,
                    )));

            $this->getContainer()->get('mailer')->send($message);
        }

        $output->writeln("Envoi d'email à ".$email);
    }
}