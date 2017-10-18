<?php
/**
 * eSports-Academy
 * Created by PhpStorm.
 * File: BotCommand.php
 * User: y4roc
 * Date: 17.10.17
 * Time: 06:23
 */

namespace eSA\TeamSpeakBundle\Command;


use eSA\TeamSpeakBundle\Event\ChannelCreatedEvent;
use eSA\TeamSpeakBundle\Event\ChannelDeletedEvent;
use eSA\TeamSpeakBundle\Event\ChannelMovedEvent;
use eSA\TeamSpeakBundle\Event\ClientEnterViewEvent;
use eSA\TeamSpeakBundle\Event\ClientLeftViewEvent;
use eSA\TeamSpeakBundle\Event\ClientMovedEvent;
use eSA\TeamSpeakBundle\Event\NotifyEvent;
use eSA\TeamSpeakBundle\Event\ServerqueryWaitTimeoutEvent;
use eSA\TeamSpeakBundle\Event\ServerSelectedEvent;
use eSA\TeamSpeakBundle\Event\TextMessageEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class BotCommand extends ContainerAwareCommand
{
    /**
     * @var \DateTime
     */
    protected static $timeout;

    /**
     * @var InputInterface
     */
    protected static $input;

    /**
     * @var OutputInterface
     */
    protected static $output;

    /**
     * @var EventDispatcher
     */
    protected static $dispatcher;

    protected function configure()
    {
        $this->setName('teamspeak:bot:start')
            ->addOption('timeout', 't', InputOption::VALUE_REQUIRED, 'Maximal execution time', "T10M");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        self::$input      = $input;
        self::$output     = $output;
        self::$dispatcher = $this->getContainer()->get('event_dispatcher');
        self::$timeout    = new \DateTime();

        $timeout      = $input->getOption('timeout');
        $dateInterval = new \DateInterval(sprintf("P%s", $timeout));
        self::$timeout->add($dateInterval);

        /**
         * @var $teamSpeak \TeamSpeak3_Node_Host
         */

        $class = get_class($this);

        \TeamSpeak3::init();

        \TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyServerselected", "$class::onSelect");
        \TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyEvent", "$class::onEvent");
        \TeamSpeak3_Helper_Signal::getInstance()->subscribe("serverqueryWaitTimeout", "$class::onTimeout");

        $teamSpeak = $this->getContainer()->get('esa_team_speak')->getTeamSpeakInstance();

        while (new \DateTime() < self::$timeout) {
            try {
                $teamSpeak->getAdapter()->wait();
            } catch (\Exception $e) {
                sleep(30);
            }
        }

    }

    public static function onEvent(\TeamSpeak3_Adapter_ServerQuery_Event $event, \TeamSpeak3_Node_Host $host)
    {
        self::$dispatcher->dispatch(NotifyEvent::getName(), new NotifyEvent($event, $host));

        switch ($event->getType()) {
            case "channelcreated":
                self::$dispatcher->dispatch(ChannelCreatedEvent::getName(), new ChannelCreatedEvent($event, $host));
                break;
            case "channelmoved":
                self::$dispatcher->dispatch(ChannelMovedEvent::getName(), new ChannelMovedEvent($event, $host));
                break;
            case "channeldeleted":
                self::$dispatcher->dispatch(ChannelDeletedEvent::getName(), new ChannelDeletedEvent($event, $host));
                break;
            case 'cliententerview':
                self::$dispatcher->dispatch(ClientEnterViewEvent::getName(), new ClientEnterViewEvent($event, $host));
                break;
            case 'clientleftview':
                self::$dispatcher->dispatch(ClientLeftViewEvent::getName(), new ClientLeftViewEvent($event, $host));
                break;
            case "clientmoved":
                self::$dispatcher->dispatch(ClientMovedEvent::getName(), new ClientMovedEvent($event, $host));
                break;
            case "textmessage":
                if ($event->getData()["invokerid"] != $host->whoami()["client_id"]) {
                    self::$dispatcher->dispatch(TextMessageEvent::getName(), new TextMessageEvent($event, $host));
                }
                break;
            default:
                break;
        }
    }

    public static function onSelect(\TeamSpeak3_Node_Host $host)
    {
        self::$dispatcher->dispatch(ServerSelectedEvent::getName(), new ServerSelectedEvent($host));

        $host->serverGetSelected()->notifyRegister("server");
        $host->serverGetSelected()->notifyRegister("channel");
        $host->serverGetSelected()->notifyRegister("textserver");
        $host->serverGetSelected()->notifyRegister("textchannel");
        $host->serverGetSelected()->notifyRegister("textprivate");
    }

    public static function onTimeout($event, $host)
    {
        dump($event);
    }
}