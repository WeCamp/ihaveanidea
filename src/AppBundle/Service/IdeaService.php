<?php

namespace AppBundle\Service;

use AppBundle\Entity\Idea;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class IdeaService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $ideaRepository;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->ideaRepository = $entityManager->getRepository(Idea::class);
    }

    /**
     * @return Idea[]
     */
    public function listIdeas()
    {
        return $this->ideaRepository->findAll();
    }
}