<?php

namespace AppBundle\Controller;

use AppBundle\Service\IdeaService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IdeaController extends Controller
{
    /**
     * @Route("/idea/list", name="idea_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render('AppBundle:Idea:list.html.twig', array(
            'ideas' => $this->get('idea.service')->listIdeas()
        ));
    }

    public function readIdeaAction()
    {

    }

    public function createIdeaAction()
    {

    }

    public function createCommentAction()
    {

    }

    public function rankIdeaAction()
    {

    }
}
