<?php
/**
 * eSports-Academy
 * Created by PhpStorm.
 * File: NotifyEvent.php
 * User: y4roc
 * Date: 17.10.17
 * Time: 06:51
 */

namespace eSA\TeamSpeakBundle\Event;


class TextMessageEvent extends NotifyEvent
{
    public static function getName()
    {
        return self::TEXT_MESSAGE;
    }
}