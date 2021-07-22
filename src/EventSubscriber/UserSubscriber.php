<?php

namespace App\EventSubscriber;

use App\Entity\User as EntityUser;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
class UserSubscriber implements EventSubscriberInterface
{
    private object $entityManager;
    private object $passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            BeforeEntityPersistedEvent::class => ['addUser'],
            BeforeEntityUpdatedEvent::class => ['updateUser']
        );
    }

    public function updateUser(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof EntityUser)) {
            return;
        }
        $this->setPassword($entity);
    }

    public function addUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof EntityUser)) {
            return;
        }
        $this->setPassword($entity);
    }

    /**
     * @param User $entity
     */
    public function setPassword(EntityUser $entity): void
    {
        $pass = $entity->getPassword();

        $entity->setPassword(
            $this->passwordEncoder->encodePassword(
                $entity,
                $pass
            )
        );
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}