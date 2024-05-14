<?php

namespace UTel\UTelSms\Test;

use UTel\SDK\UTel as UTelSDK;
use UTel\SDK\SMS;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;

use Mockery;
use UTel\UTelSms\UTelSmsChannel;
use UTel\UTelSms\UTelSmsMessage;
use UTel\UTelSms\Exceptions\CouldNotSendNotification;

class UTelSmsChannelTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $utelSdk;

    /** @var \UTel\UTelSms\UTelSmsChannel */
    protected $channel;

    public function setUp(): void
    {
        parent::setUp();
        $this->utelSdk = Mockery::mock(UTelSDK::class);
        $this->sms = Mockery::mock(SMS::class);

        $this->channel = new UTelSmsChannel($this->utelSdk);
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(UTelSDK::class, $this->utelSdk);
        $this->assertInstanceOf(UTelSmsChannel::class, $this->channel);
    }

    /** @test */
    public function it_can_send_sms_notification_to_notifiable_with_method()
    {
        $this->utelSdk->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send(new NotifiableWithMethod, new TestNotification);
    }

    /** @test */
    public function it_can_send_sms_notification_to_anonymous_notifiable_using_class_name()
    {
        $this->utelSdk->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send((new AnonymousNotifiable())->route(UTelSmsChannel::class, '+1111111111'), new TestNotification);
    }

    /** @test */
    public function it_can_send_sms_notification_to_anonymous_notifiable_using_string_name()
    {
        $this->utelSdk->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send((new AnonymousNotifiable())->route('UTelSms', '+1111111111'), new TestNotification);
    }

    /** @test */
    public function it_can_send_sms_notification_to_notifiable_with_attribute()
    {
        $this->utelSdk->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send(new NotifiableWithAttribute(), new TestNotification);
    }

    /** @test */
    public function it_can_send_sms_notification_to_message_get_to()
    {
        $this->utelSdk->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send(new AnonymousNotifiable(), new TestNotificationWithGetTo);
    }
}

class NotifiableWithMethod
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return string
     */
    public function routeNotificationForAfricasTalking()
    {
        return '+2341111111111';
    }
}

class TestNotification extends Notification
{
    /**
     * @param $notifiable
     * @return UTelSmsMessage
     *
     * @throws CouldNotSendNotification
     */
    public function toAfricasTalking($notifiable)
    {
        return new UTelSmsMessage();
    }
}

class TestNotificationWithGetTo extends Notification
{
    /**
     * @param $notifiable
     * @return UTelSmsMessage
     *
     * @throws CouldNotSendNotification
     */
    public function toAfricasTalking($notifiable)
    {
        return (new UTelSmsMessage())
                    ->to('+22222222222');
    }
}

class Notifiable
{
    public $phone_number = null;

    public function routeNotificationFor()
    {
    }
}

class NotifiableWithAttribute
{
    public $phone_number = '+22222222222';

    public function routeNotificationFor()
    {
    }
}