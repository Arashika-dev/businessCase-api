<?php
namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;


class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event)
    {

        $payload = $event->getData();
        $user = $event->getUser();

        // Add the user ID to the payload
        $payload['id'] = $user->getId();

        $event->setData($payload);

    }
}
 