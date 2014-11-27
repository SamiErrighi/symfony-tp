<?php

namespace Cergy\BookBundle\Controller;

use Cergy\BookBundle\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @route("/category")
 */
class CategoryController extends Controller
{
    /**
     * create a new category
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new CategoryType());

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()) {
                //check if the category already exist
                if($this->categoryAlreadyExist($form->getData()->getName())) {
                    $this->get('session')->getFlashBag()->add("success", "Category already exist");
                    return $this->redirect($this->generateUrl('cergy_book_category_create'));
                }

                $em =  $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->getFlashBag()->add("success", "Category created");
                return $this->redirect($this->generateUrl('books_list'));
            }
        }

        return [
            "form" => $form->createView()
        ];
    }

    //check method
    private function categoryAlreadyExist($name)
    {
        $category = $this->getDoctrine()
            ->getRepository('CergyBookBundle:Category')
            ->findByName($name)
        ;


        if(null != $category) {
            return true;
        }

        return false;
    }
}