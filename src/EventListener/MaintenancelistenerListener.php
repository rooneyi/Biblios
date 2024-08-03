<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class MaintenancelistenerListener
{
    public const IS_MAINTENANCE = false;
    public function __construct(private readonly Environment $twig)
    {

    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    #[AsEventListener(event: KernelEvents::REQUEST,priority: 2000)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if(self::IS_MAINTENANCE){
            $response = new Response($this->twig->render('maintenance.html.twig'));
            $event->setResponse($response);
        }
        // ...
    }
}
