<?php

namespace AppBundle\Controller;

use AppBundle\Service\IdeaService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Idea;
use AppBundle\Form\Type\Idea as IdeaForm;
use AppBundle\Form\Handler\Idea as IdeaFormHandler;

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

        return $this->render(
            'AppBundle:Idea:view.html.twig',
            [
                //'idea' => $ideaService->getIdea($id),
                // Static data to prettify the idea page
                'idea' => [
                    'id' => '123',
                    'title' => 'What about movie',
                    'createdAt' => time(),
                    'description' => 'On Christmas Eve, New York City Police Detective Lieutenant John McClane arrives
                    in Los Angeles to reconcile with his estranged wife, Holly. McClane is driven to the Nakatomi Plaza
                    building for a company Christmas party by Argyle. While McClane changes clothes, the party is
                    disrupted by the arrival of Hans Gruber and his heavily armed group: Karl, Franco, Tony, Theo,
                    Alexander, Marco, Kristoff, Eddie, Uli, Heinrich, Fritz, and James.',
                    'user' => [
                        'username' => 'Bruce Willis'
                    ],
                    'comments' => [
                        [
                            'user' => [
                                'username' => 'David Guetta',
                            ],
                            'content' => 'Great!',
                            'createdAt' => time(),
                        ],
                        [
                            'user' => [
                                'username' => 'Armin van Buuren',
                            ],
                            'content' => 'Like it!',
                            'createdAt' => time(),
                        ]
                    ]
                ],
            ]
        );
    }

    /**
     * @param Request $request
     * @Route("/idea/create", name="idea_create")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createIdeaAction(Request $request)
    {
        /** @var IdeaFormHandler $ideaFormHandler */
        $ideaFormHandler = $this->get('idea.create.form.handler');

        $form = $ideaFormHandler->form();

        if ($request->isMethod('POST')) {
            $ideaFormHandler->process($request, $form);
        }

        return $this->render('AppBundle:Idea:create.html.twig', array(
            'form' => $form->createView(),
        ));
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
