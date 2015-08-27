<?php

namespace AppBundle\Controller;

use AppBundle\Service\IdeaService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        return $this->render('AppBundle:Idea:view.html.twig', array(
            'idea' => $this->get('idea.service')->getIdea($id),
        ));
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
