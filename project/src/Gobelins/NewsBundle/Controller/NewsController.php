<?php

namespace Gobelins\NewsBundle\Controller;

use Gobelins\NewsBundle\Entity\News;
use Gobelins\NewsBundle\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class NewsController extends Controller
{
    /**
     * @Route("/", name="news_list")
     */
    public function listAction()
    {
        $news = $this->getDoctrine()->getRepository('GobelinsNewsBundle:News')->findAll();

        return $this->render('GobelinsNewsBundle:News:list.html.twig', [
            'news' => $news
        ]);
    }

    /**
     * @Route("/create", name="news_create")
     */
    public function createAction(Request $request)
    {
        $currentUser = $this->getUser();
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        //if ($currentUser) {
            $form = $this->createForm(new NewsType());

            if ($request->isMethod('POST')) {
                $form->handleRequest($request);

                if ($form->isValid()) {
                    /** @var News $news */
                    $news = $form->getData();

                    $news->setAuthor($currentUser);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($news);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('success', 'Your news has been successfully added !');
                    return $this->redirect($this->generateUrl('news_list'));
                }
            }
        //} else {
        //    return $this->redirect($this->generateUrl('fos_user_security_login'));
        //}

        return $this->render('GobelinsNewsBundle:News:create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
