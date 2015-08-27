<?php

namespace AppBundle\Form\Handler;

use AppBundle\Entity\Link;
use AppBundle\Service\IdeaService;
use AppBundle\Service\LinkService;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Idea as IdeaEntity;
use AppBundle\Entity\Link as LinkEntity;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class Idea
{
    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var IdeaService
     */
    private $ideaService;

    /**
     * @var LinkService
     */
    private $linkService;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param FormFactory $formFactory
     * @param FormTypeInterface $form
     * @param IdeaService $ideaService
     * @param LinkService $linkService
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        FormFactory $formFactory,
        FormTypeInterface $form,
        IdeaService $ideaService,
        LinkService $linkService,
        TokenStorageInterface $tokenStorage
    ) {
        $this->formFactory = $formFactory;
        $this->form = $form;
        $this->ideaService = $ideaService;
        $this->linkService = $linkService;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param null $idea
     * @return \Symfony\Component\Form\Form|FormInterface
     */
    public function form($idea = null)
    {
        return $this->formFactory->create($this->form, $idea);
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     */
    public function process(Request $request, FormInterface $form)
    {
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $idea = new IdeaEntity();
            $idea
                ->setTitle($data['title'])
                ->setDescription($data['description'])
                ->setUser($this->getUserFromTokenStorage());

            $this->ideaService->saveIdea($idea);

            if ($data['youtube-flag'] === true) {
                $youtubeLink = new Link();
                $youtubeLink
                    ->setIdea($idea)
                    ->setType(Link::TYPE_YOUTUBE)
                    ->setLink($data['youtube-value']);
                $this->linkService->saveLink($youtubeLink);
            }
        }
    }

    private function getUserFromTokenStorage()
    {
        if (($token = $this->tokenStorage->getToken()) !== null) {
            return $token->getUser();
        }

        throw new \RuntimeException('I don\'t have a token');
    }
}
