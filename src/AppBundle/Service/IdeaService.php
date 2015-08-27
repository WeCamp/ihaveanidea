<?php

namespace AppBundle\Service;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Idea;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

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
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @param EntityManager $entityManager
     * @param TokenStorage  $tokenStorage
     */
    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->ideaRepository = $entityManager->getRepository(Idea::class);
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return Idea[]
     */
    public function listIdeas()
    {
        return $this->ideaRepository->findAll();
    }

    /**
     * @param $id
     *
     * @return null|Idea
     */
    public function getIdea($id)
    {
        return $this->ideaRepository->find($id);
    }

    /**
     * @param int $ideaId
     * @param string $content
     *
     * @return Comment
     * @throws \Exception
     */
    public function comment($ideaId, $content)
    {
        $idea = $this->getIdea($ideaId);

        if(($idea instanceof Idea) === false) {
            throw new \Exception("Unknown Idea[id={$ideaId}] aka 'I have no idea!'");
        }

        $userPasswordToken = $this->tokenStorage->getToken();
        $user = $userPasswordToken->getUser();

        $this->ensureAuthenticated($user);

        $comment = new Comment();
        $comment->setIdea($idea);
        $comment->setContent($content);
        $comment->setUser($user);
        $comment->setPrivate(false);
        $comment->setCreatedAt(new \DateTime());

        $this->entityManager->persist($comment);
        $this->entityManager->flush($comment);

        return $comment;
    }

    /**
     * @param User $user
     *
     * @throws \Exception
     */
    private function ensureAuthenticated(User $user = null)
    {
        if (($user instanceof User) === false) {
            throw new \Exception("User must be logged in");
        }
    }
}