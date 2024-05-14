<?php

namespace UTel\UTelSms;

use UTel\SDK\UTel as UTelSDK;
use UTel\UTelSms\Exceptions\CouldNotSendNotification;
use UTel\UTelSms\Exceptions\InvalidPhonenumber;
use Illuminate\Notifications\Notification;

use Exception;

class UTelSmsChannel
{

	/** @var UTelSDK */
	protected $utelsms;

	public function __construct(UTelSDK $utelsms)
	{
		$this->utelsms = $utelsms;
	}

	/**
	 * Send the given notification.
	 *
	 * @param  mixed  $notifiable
	 * @param  \Illuminate\Notifications\Notification  $notification
	 *
	 * @throws CouldNotSendNotification
	 */
	public function send($notifiable, Notification $notification)
	{
		$message = $notification->toUTelSms($notifiable);

		$phoneNumber = $this->getTo($notifiable, $notification, $message);

		if (empty($phoneNumber)) {
			throw InvalidPhonenumber::configurationNotSet();
		}

		if (empty(($message->getSender())) || is_null($message->getSender())) {
			$params = [
				'to'        => $phoneNumber,
				'message'   => $message->getContent(),
			];
		} else {
			$params = [
				'to'        => $phoneNumber,
				'message'   => $message->getContent(),
				'from'      => $message->getSender(),
			];
		}

		try {
			return $this->utelsms->sms()->send($params);
		} catch (Exception $e) {
			throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
		}
	}

	private function getTo($notifiable, Notification $notification, UTelSmsMessage $message)
	{
		if (!empty($message->getTo())) {
			return $message->getTo();
		}

		if ($notifiable->routeNotificationFor(static::class, $notification)) {
			return $notifiable->routeNotificationFor(static::class, $notification);
		}

		if ($notifiable->routeNotificationFor('utelSms', $notification)) {
			return $notifiable->routeNotificationFor('utelSms', $notification);
		}

		if (isset($notifiable->phone_number)) {
			return $notifiable->phone_number;
		}

		throw CouldNotSendNotification::invalidReceiver();
	}

}
