<?php
/**
 * eSports-Academy
 * Created by PhpStorm.
 * File: TeamSpeak3Api.php
 * User: y4roc
 * Date: 17.10.17
 * Time: 06:26
 */

namespace eSA\TeamSpeakBundle\Service;

/**
 * Class TeamSpeak3Api
 *
 * @package eSA\TeamSpeakBundle\Service
 * @method
 */
class TeamSpeak3Api
{
    protected $teamSpeakInstance = null;

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

        $this->teamSpeakInstance = \TeamSpeak3::factory($uri);
    }

    /**
     * @return \TeamSpeak3_Adapter_Abstract
     */
    public function getTeamSpeakInstance()
    {
        return $this->teamSpeakInstance;
    }

    /**
     * @param \TeamSpeak3_Adapter_Abstract $teamSpeakInstance
     */
    public function setTeamSpeakInstance($teamSpeakInstance)
    {
        $this->teamSpeakInstance = $teamSpeakInstance;
    }

}