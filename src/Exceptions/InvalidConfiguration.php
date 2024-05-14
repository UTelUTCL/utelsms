<?php

namespace UTel\UTelSms\Exceptions;

class InvalidConfiguration extends \Exception
{
	public static function configurationNotSet(): self
	{
		return new static('To send notifications via UTelSms you need to add credentials in the `utelsms` key of `config.services`.');
	}
}
