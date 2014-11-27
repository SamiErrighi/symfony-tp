<?php

namespace Cergy\ApiBundle\Controller;

use Cergy\BookBundle\Form\Type\BookType;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;


class BooksController extends Controller
{
    /**
     * get all book
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getBooksAction()
    {
        $books = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Book')
            ->findAll()
        ;

        $view = $this->view($books, 200);

        return $this->handleView($view);
    }

    /**
     * update a book
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postBooksAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('form', new BookType(), [
            'csrf_protection' => false,
            'method'          => $request->getMethod()
        ]);
        $form->handleRequest($request);

        if( $form->isValid() ) {
            $em = $this->getDoctrine()->getManagers();
            $em->persist($form->getData());
            $em->flush();

            return $this->handleView($this->view(null, Codes::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view([
            'error' => (string) $form->getErrors()
        ], Codes::HTTP_BAD_REQUEST));
    }

    /**
     * delete a book
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteBooksAction($id)
    {
        $book = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Book')
            ->find($id)
        ;

        if(null === $book) {
            return $this->handleView($this->view([
                'error' => (string) $form->getErrors()
            ], Codes::HTTP_BAD_REQUEST));
        }

        $em =  $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();


        return $this->handleView($this->view(null, Codes::HTTP_NO_CONTENT));
    }
}
