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
        return [];
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new BookType());
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()) {

                $em =  $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->getFlashBag()->add("success", "book created");
                return $this->redirect($this->generateUrl('books_list '));
            }
        }

        return [
            "form" => $form->createView()
        ];
    }
}
