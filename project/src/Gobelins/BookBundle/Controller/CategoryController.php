<?php

namespace Gobelins\BookBundle\Controller;

use Gobelins\BookBundle\Entity\Category;
use Gobelins\BookBundle\Form\CategoryType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/category/", name="category_list")
     */
    public function listAction()
    {
        $category = $this->getDoctrine()->getRepository('GobelinsBookBundle:Category')->findAll();

        return $this->render('GobelinsBookBundle:Category:list.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Secure(roles="ROLE_USER")
     * @Route("/category/create", name="category_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new CategoryType());

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                /** @var Category $category */
                $category = $form->getData();

                $duplicate = $em->getRepository('GobelinsBookBundle:Category')->findOneBy(['title' => $category->getTitle()]);
                if ($duplicate) {
                    $this->get('session')->getFlashBag()->add('error', 'Your category '.$category->getTitle().' already exist');
                    return $this->redirect($this->generateUrl('category_create'));
                }

                $em->persist($category);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Your category has been successfully added !');
                return $this->redirect($this->generateUrl('category_list'));
            }
        }

        return $this->render('GobelinsBookBundle:Category:create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
