<?php

namespace Gobelins\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Gobelins\BookBundle\Form\BookType;
use Gobelins\BookBundle\Entity\Book;

class BookController extends FOSRestController
{
    /**
     * @Route("/book")
     */
    public function getBookAction()
    {
        $allBook = $this->getDoctrine()->getRepository('GobelinsBookBundle:Book')->findAll();
        return $this->handleView($this->view($allBook));
    } //get_book

    public function postBookAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('form', new BookType(), null, [
            'csrf_protection' => false
        ]);

        $form->handleRequest($request);
        /** @var Book $books */
        $book = $form->getData();

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('GobelinsUserBundle:User')->findAll();

        if ($users[0] == null) {
            return $this->handleView($this->view([
                'message' => 'No user in the database'
            ], Codes::HTTP_BAD_REQUEST));
        }
        $book->setAuthor($users[0]);
        if ($form->isValid()) {

            $em->persist($book);
            $em->flush();

            return $this->handleView($this->view([
                'message' => 'Your book has been successfully added !'
            ], Codes::HTTP_CREATED));
        }

        return $this->handleView($this->view([
            'message' => (string) $form->getErrors()
        ], Codes::HTTP_BAD_REQUEST));

    } //post_book

    public function patchBookAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Book $book */
        $book = $em->getRepository('GobelinsBookBundle:Book')->find($id);
        $form = $this->get('form.factory')->createNamed('form', new BookType(), $book, [
            'csrf_protection' => false,
            'method' => $request->getMethod()
        ]);

        if (null == $book) {
            throw $this->createNotFoundException();
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $book = $form->getData();

            $em->persist($book);
            $em->flush();

            return $this->handleView($this->view(null, Codes::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view([
            'message' => (string) $form->getErrors()
        ], Codes::HTTP_BAD_REQUEST));
    } //patch_book

    public function deleteBookAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Book $book */
        $book = $em->getRepository('GobelinsBookBundle:Book')->find($id);

        if (null == $book) {
            throw $this->createNotFoundException();
        }

        $em->remove($book);
        $em->flush();

        return $this->handleView($this->view(null, Codes::HTTP_NO_CONTENT));
    } //patch_book
}
