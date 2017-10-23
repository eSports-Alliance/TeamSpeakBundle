<?php
/**
 * eSports-Academy
 * Created by PhpStorm.
 * File: BotRunCommand.php
 * User: y4roc
 * Date: 18.10.17
 * Time: 18:12
 */

namespace ESA\TeamSpeakBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class BotStopCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName("teamspeak:bot:stop")
        ->setDescription("Stop running TeamSpeak-Bot")->setDescription("Stop current running TeamSpeak-Bot.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pidFile = sprintf("%s/../.teamspeak-bot.pid", $this->getContainer()->get('kernel')->getRootDir());

        if (false === file_exists($pidFile)) {
            $output->writeln("No running Teamspeak-Bot instance found");

            return;
        }
        $pid     = file_get_contents($pidFile);
        $process = new Process(sprintf("kill -9 %s", $pid));
        $process->run();
        unlink($pidFile);

        $output->writeln("Teamspeak-Bot successfully stopped");
    }
}