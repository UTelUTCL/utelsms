<?php

namespace UTel\UTelSms\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("Oops! Something went wrong while sending the notification. Please try again later.");
    }

    public static function invalidReceiver()
    {
        return new static("Oops! Something went wrong while sending the notification. Please try again later.");
    }
}
