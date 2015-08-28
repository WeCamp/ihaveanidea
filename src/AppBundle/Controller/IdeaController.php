<?php

namespace AppBundle\Controller;

use AppBundle\Service\IdeaService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class IdeaController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render('AppBundle:Idea:list.html.twig', array(
            'ideas' => $this->get('idea.service')->listIdeas()
        ));
    }

    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id)
    {
        /** @var IdeaService $ideaService */
        $ideaService = $this->get('idea.service');

        return $this->render('AppBundle:Idea:view.html.twig', array(
            'idea' => $ideaService->getIdea($id),
            'comments' => $ideaService->getCommentsForIdea($id)
        ));
    }

    public function createIdeaAction()
    {

    }

    public function createCommentAction($id, Request $request)
    {
        $private = false;

        if($request->get('private') === 'on') {
            $private = true;
        }

        $this->get('idea.service')->comment($id, $request->get('comment'), $private);
        return $this->redirectToRoute('idea_view', [ 'id' => $id ]);
    }

    public function rankIdeaAction()
    {

    }
}
