<?php

namespace UTel\UTelSms;

use Illuminate\Support\Arr;

class UTelSmsMessage
{

	/** @var string */
	protected $content;

	/** @var string|null */
	protected $from;

	/** @var string|null */
	protected $to;

   /**
	* Set content for this message.
	*
	* @param  string  $content
	* @return $this
	*/
	public function content(string $content): self
	{
		$this->content = trim($content);

		return $this;
	}

   /**
	* Set sender for this message.
	*
	* @param  string  $from
	* @return self
	*/
	public function from(string $from): self
	{
		$this->from = trim($from);

		return $this;
	}

   /**
	* Set recipient for this message.
	*
	* @param  string  $from
	* @return self
	*/
	public function to(string $to): self
	{
		$this->to = trim($to);

		return $this;
	}

   /**
	* Get message content.
	*
	* @return string
	*/
	public function getContent()
	{
		return $this->content;
	}

   /**
	* Get sender info.
	*
	* @return string
	*/
	public function getSender()
	{
		return $this->from ?? config('services.utelsms.from');
	}

   /**
	* Get recipient info.
	*
	* @return string
	*/
	public function getTo()
	{
		return $this->to ?? null;
	}
	
}
