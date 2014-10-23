<?php

namespace Gobelins\BookBundle\Controller;

use Gobelins\BookBundle\Entity\Book;
use Gobelins\BookBundle\Form\BookType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    /**
     * @Route("/book/", name="book_list")
     */
    public function listAction()
    {
        $book = $this->getDoctrine()->getRepository('GobelinsBookBundle:Book')->findAll();

        return $this->render('GobelinsBookBundle:Book:list.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Secure(roles="ROLE_USER")
     * @Route("/book/create", name="book_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new BookType());

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var Book $book */
                $book = $form->getData();
                $currentUser = $this->getUser();
                $book->setAuthor($currentUser);

                $em = $this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Your book has been successfully added !');
                return $this->redirect($this->generateUrl('book_list'));
            }
        }

        return $this->render('GobelinsBookBundle:Book:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Secure(roles="ROLE_USER")
     * @Route("/book/edit/{id}", name="book_update")
     */
    public function updateAction($id, Request $request)
    {
        if (is_null($id)) {
            $postData = $request->get('book');
            $id = $postData['id'];
        }

        $em = $this->getDoctrine()->getManager();
        /** @var Book $book */
        $book = $em->getRepository('GobelinsBookBundle:Book')->find($id);
        if (null == $book) {
            $this->get('session')->getFlashBag()->add('success', 'Book with id : ' . $id . ' doesn\'t exit !');
            return $this->redirect($this->generateUrl('book_list'));
        }

        $form = $this->createForm(new BookType(), $book);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var Book $book */
                $book = $form->getData();

                $em->persist($book);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Book '. $book->getTitle() .' have been successfully update !');
                return $this->redirect($this->generateUrl('book_list'));
            }
        }

        return $this->render('GobelinsBookBundle:Book:update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Secure(roles="ROLE_USER")
     * @Route("/book/delete/{id}", name="book_delete")
     */
    public function deleteAction($id, Request $request)
    {
        if (is_null($id)) {
            $postData = $request->get('book');
            $id = $postData['id'];
        }

        $em = $this->getDoctrine()->getManager();
        /** @var Book $book */
        $book = $em->getRepository('GobelinsBookBundle:Book')->find($id);
        if (null == $book) {
            $this->get('session')->getFlashBag()->add('success', 'Book with id : ' . $id . ' doesn\'t exit !');
            return $this->redirect($this->generateUrl('book_list'));
        }

        $em->remove($book);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Book '. $book->getTitle() .' have been successfully update !');
        return $this->redirect($this->generateUrl('book_list'));
    }
}
