<?php
/**
 * eSports-Academy
 * Created by PhpStorm.
 * File: TeamSpeak3Api.php
 * User: y4roc
 * Date: 17.10.17
 * Time: 06:26
 */

namespace ESA\TeamSpeakBundle\Service;

/**
 * Class TeamSpeak3Api
 *
 * @package eSA\TeamSpeakBundle\Service
 * @method
 */
class TeamSpeak3Api
{
    protected static $teamSpeakInstance = null;

    /**
     * @param $host
     * @param $port
     * @param $query_port
     * @param $username
     * @param $password
     * @param null $nickname
     * @param int $timeout
     */
    public function __construct($host,
                                $port,
                                $query_port,
                                $username,
                                $password,
                                $nickname = null,
                                $timeout = 10)
    {
        if (null !== self::$teamSpeakInstance) {
            return;
        }

        if (null !== $nickname) {
            $nickname = sprintf("&nickname=%s", $nickname);
        }

        $uri = sprintf("serverquery://%s:%s@%s:%s/?server_port=%s&timout=3&blocking=0%s&timeout=%s",
            $username,
            $password,
            $host,
            $query_port,
            $port,
            $nickname,
            $timeout);

        self::$teamSpeakInstance = \TeamSpeak3::factory($uri);
    }

    /**
     * @return \TeamSpeak3_Adapter_Abstract
     */
    public static function getTeamSpeakInstance()
    {
        return self::$teamSpeakInstance;
    }

}