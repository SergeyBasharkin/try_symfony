<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 16.11.17
 * Time: 17:07
 */
namespace AppBundle\Listeners;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event){
        $request = $event->getRequest();
        $browser = $request->headers->get("User-Agent");
        $browser = explode('/', $browser)[0];
        $request->query->add(array("browser"=>$browser));
    }
}