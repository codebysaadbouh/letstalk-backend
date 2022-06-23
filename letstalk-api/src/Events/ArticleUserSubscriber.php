<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Article;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use \Symfony\Component\Security\Core\Security;

class ArticleUserSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setUserForCostumer', EventPriorities::PRE_VALIDATE]
        ];
    }



    public function setUserForCostumer(ViewEvent $event)
    {
        $article = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (($article instanceof Article) && ($method === 'POST')) {
            // Récupérer l'utilisateur connecté
            $user = $this->security->getUser();
            // Assigner l'utilisateur connecté à l'article
            $article->setUsercreator($user);
        }


    }

}