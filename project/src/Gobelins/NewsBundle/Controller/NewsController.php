<?php

namespace Gobelins\NewsBundle\Controller;

use Gobelins\NewsBundle\Entity\News;
use Gobelins\NewsBundle\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
     * @Secure(roles="ROLE_USER")
     * @Route("/create", name="news_create")
     */
    public function createAction(Request $request)
    {
        /* or with annotation above
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        */
        //Old way to to id, see above for the correct way
        //if ($currentUser) {
            $form = $this->createForm(new NewsType());

            if ($request->isMethod('POST')) {
                $form->handleRequest($request);

                if ($form->isValid()) {
                    /** @var News $news */
                    $news = $form->getData();

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

    /**
     * @Secure(roles="ROLE_USER")
     * @Route("/edit/{id}", name="news_update")
     */
    public function updateAction($id, Request $request)
    {
        if (is_null($id)) {
            $postData = $request->get('news');
            $id = $postData['id'];
        }

        $em = $this->getDoctrine()->getManager();
        /** @var News $news */
        $news = $em->getRepository('GobelinsNewsBundle:News')->find($id);
        if (null == $news) {
            $this->get('session')->getFlashBag()->add('success', 'News with id : ' . $id . ' doesn\'t exit !');
            return $this->redirect($this->generateUrl('news_list'));
        }

        $form = $this->createForm(new NewsType(), $news);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var News $news */
                $news = $form->getData();

                $em->persist($news);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'News '. $news->getTitle() .' have been successfully update !');
                return $this->redirect($this->generateUrl('news_list'));
            }
        }

        return $this->render('GobelinsNewsBundle:News:update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
