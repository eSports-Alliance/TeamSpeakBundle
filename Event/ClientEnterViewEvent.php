<?php
/**
 * eSports-Academy
 * Created by PhpStorm.
 * File: ClientEnterViewEvent.php
 * User: y4roc
 * Date: 17.10.17
 * Time: 06:46
 */

namespace ESA\TeamSpeakBundle\Event;


class ClientEnterViewEvent extends NotifyEvent
{
    public static function getName()
    {
        return self::CLIENT_ENTER_VIEW;
    }
}