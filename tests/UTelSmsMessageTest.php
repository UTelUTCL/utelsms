<?php

namespace UTel\UTelSms\Test;

use UTel\UTelSms\UTelSmsMessage;

class UTelSmsMessageTest extends TestCase
{

	/** @var UTelSmsMessage */
	protected $message;

	public function setUp(): void
	{
		parent::setUp();
		$this->message = new UTelSmsMessage();
		config(['services.utelsms.from' => 'UTel']);
	}

	/** @test */
	public function it_can_get_the_content()
	{
		$this->message->content('myMessage');
		$this->assertEquals('myMessage', $this->message->getContent());
	}

	/** @test */
	public function it_can_get_the_sender()
	{
		$this->message->from('UTELSHORTCODE');
		$this->assertEquals('UTELSHORTCODE', $this->message->getSender());
	}

	/** @test */
	public function it_can_get_the_default_sender()
	{
		$this->assertEquals('UTel', $this->message->getSender());
	}

}