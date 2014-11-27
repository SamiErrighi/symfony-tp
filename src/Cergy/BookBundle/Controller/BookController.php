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
     * get all book
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
     * edit a book
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

        //if book is not defined redirect book list
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
     * create a book
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        //check if a categories exists
        $categories = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Category')
            ->findAll()
        ;

        //no categories redirect to book list
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
     * delete a book
     * @Route("/delete/{id}", methods={"GET"})
     * @Template()
     */
    public function deleteAction($id)
    {
        //retrieve the book
        $book = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Book')
            ->find($id)
        ;

        //if book is not defined redirect to list book
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
