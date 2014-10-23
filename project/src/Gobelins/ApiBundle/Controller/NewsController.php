<?php

namespace Gobelins\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Gobelins\NewsBundle\Form\NewsType;
use Gobelins\NewsBundle\Entity\News;

class NewsController extends FOSRestController
{
    /**
     * @Route("/news")
     */
    public function getNewsAction()
    {
        $allNews = $this->getDoctrine()->getRepository('GobelinsNewsBundle:News')->findAll();
        return $this->handleView($this->view($allNews));
    } //get_news

    public function postNewsAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('form', new NewsType(), null, [
            'csrf_protection' => false
        ]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var News $news */
            $news = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            return $this->handleView($this->view([
                'message' => 'Your news has been successfully added !'
            ], Codes::HTTP_CREATED));
        }

        return $this->handleView($this->view([
            'message' => (string) $form->getErrors()
        ], Codes::HTTP_BAD_REQUEST));

    } //post_news

    public function patchNewsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var News $news */
        $news = $em->getRepository('GobelinsNewsBundle:News')->find($id);
        $form = $this->get('form.factory')->createNamed('form', new NewsType(), $news, [
            'csrf_protection' => false,
            'method' => $request->getMethod()
        ]);

        if (null == $news) {
            throw $this->createNotFoundException();
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $news = $form->getData();

            $em->persist($news);
            $em->flush();

            return $this->handleView($this->view(null, Codes::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view([
            'message' => (string) $form->getErrors()
        ], Codes::HTTP_BAD_REQUEST));
    } //patch_news
}
