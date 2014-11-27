<?php

namespace Cergy\BookBundle\Controller;

use Cergy\BookBundle\Form\Type\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @route("/book")
 */
class BookController extends Controller
{
    /**
     * @Route("/", name="books_list")
     * @Template()
     */
    public function indexAction()
    {
        $books = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Book')
            ->findAll()
        ;
        return [
            "books" => $books
        ];
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        //get book
        $book = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Book')
            ->find($id)
        ;

        if( null == $book) {
            $this->get('session')->getFlashBag()->add("success", "book doesn't exist");
            return $this->redirect($this->generateUrl('books_list'));
        }

        $form = $this->createForm(new BookType(), $book);
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()) {

                $em =  $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->getFlashBag()->add("success", "book updated");
                return $this->redirect($this->generateUrl('books_list'));
            }
        }
        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Category')
            ->findAll()
        ;

        if(count($categories) <= 0) {
            $this->get('session')->getFlashBag()->add("success", "create a category first");
            return $this->redirect($this->generateUrl('books_list'));
        }

        $form = $this->createForm(new BookType());
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()) {

                $em =  $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->getFlashBag()->add("success", "book created");
                return $this->redirect($this->generateUrl('books_list'));
            }
        }

        return [
            "form" => $form->createView()
        ];
    }

    /**
     * @Route("/delete/{id}", methods={"GET"})
     * @Template()
     */
    public function deleteAction($id)
    {
        $book = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Book')
            ->find($id)
        ;

        if(null == $book) {
            $this->get('session')->getFlashBag()->add("success", "book doesn't exist");
            return $this->redirect($this->generateUrl('books_list'));
        }

        $em =  $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        $this->get('session')->getFlashBag()->add("success", "book destroyed");
        return $this->redirect($this->generateUrl('books_list'));
    }
}
