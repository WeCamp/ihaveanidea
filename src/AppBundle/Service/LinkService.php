<?php

namespace AppBundle\Service;

use AppBundle\Entity\Link;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class LinkService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $linkRepository;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->linkRepository = $entityManager->getRepository(Link::class);
    }

    /**
     * @param Link $link
     */
    public function saveLink(Link $link)
    {
        $this->entityManager->persist($link);
        $this->entityManager->flush($link);
    }
}
