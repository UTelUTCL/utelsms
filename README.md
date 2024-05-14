# UTelSms notification channel for Laravel

## Contents

- [About](#about)
- [Installation](#installation)
- [Setting up the AfricasTalking service](#setting-up-the-utelsms-service)
- [Usage](#usage)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)
  
## Installation

You can install this package via composer:

``` bash
composer require utel/utelsms
```

The service provider gets loaded automatically.

### Setting up the UTelSms service

**Please note if you do not have a VALID sender_ID remove "AT_FROM" from your .env or leave it as ""**


```bash
UTCL_BASE_DOMAIN=""
UTCL_TOKEN=""
UTCL_FROM=""
```

To load them, add this to your `config/services.php` . This will load the AfricasTalking  data from the `.env` file.file:

```php
'utelsms' => [
    'baseDomain'      => env('UTCL_BASE_DOMAIN'),
    'token'           => env('UTCL_KEY'),
    'from'          => env('UTCL_FROM'),
]
```

Add the `routeNotificationForUTelSms` method on your notifiable Model. If this is not added,
the `phone_number` field will be automatically used.  

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForUTelSms($notification)
    {
        return $this->phone_number;
    }
}
```


## Usage


To use this package, you need to create a notification class, like `NewsWasPublished` from the example below, in your Laravel application. Make sure to check out [Laravel's documentation](https://laravel.com/docs/master/notifications) for this process.


```php
<?php

use NotificationChannels\UTelSms\UTelSmsChannel;
use NotificationChannels\UTelSms\UTelSmsMessage;

class NewsWasPublished extends Notification
{

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [UTelSmsChannel::class];
    }

    public function toUTelSms($notifiable)
    {
		return (new UTelSmsMessage())
                    ->content('Your SMS message content');

    }
}
```
You can also modify who the notification(SMS) is sent from, this will override the AT_FROM= in your .env
**Please only do this if you have a VALID sender_ID**

``` php
        return (new UTelSmsMessage())
                    ->content("Your SMS message content")
                    ->from("set any sender id/name here");
```

You can also modify who the notification(SMS) is sent to (the recipient)

``` php
        return (new UTelSmsMessage())
                    ->content("Your SMS message content")
                    ->to("put the recipient phone number here"); //eg ->to(716094525)
```
It's important to know the Order in which the recipient phone number the notification(SMS) will be sent to will be used

1) If you have defined the routeNotificationForUTelSms() method on the Notifiable class (User.php in this case) and returned a valid phone number, then that will be used.

2) if you did not define routeNotificationForUTelSms() method on the Notifiable class (User.php in this case), then the phone_number attribute of the User will be used ($user->phone_number)

3) Lastly if the recipient phone number is set using ->to(716094525), this will override the phone number provided in either 1 or 2.

``` php
        return (new UTelSmsMessage())
                    ->content("Your SMS message content")
                    ->to("put the recipient phone number here"); //eg ->to(716094525)
```

## Testing

``` bash
$ composer test
```

## Security

If you discover any security-related issues, please email osaigbovoemmanuel1@gmail.com instead of using the issue tracker.

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
