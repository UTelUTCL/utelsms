<?php

namespace UTel\UTelSms\Exceptions;

class InvalidPhonenumber extends \Exception
{
	public static function configurationNotSet(): self
	{
		return new static(
			"please provide a phonenumber to which the notification(SMS) will be sent to, you can do these in three ways: 
			1) by defining a routeNotificationForUTelSms method on your notifiable entity
			or
			2) by creating a new column called `phone` in your notifiable table
			3) by chaining from(phonenumber) method to your UTelSmsMessage() eg (new UTelSmsMessage())
			->content('Your SMS message content')->to(11111111); method in your event class 
			"
		);
	}
}
