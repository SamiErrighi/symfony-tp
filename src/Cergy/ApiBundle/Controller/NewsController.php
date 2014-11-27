<?php

namespace Cergy\ApiBundle\Controller;

use Cergy\NewsBundle\Form\Type\NewsType;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;


class NewsController extends Controller
{

    public function getNewsAction()
    {
        $news = $this->getDoctrine()
            ->getRepository('CergyNewsBundle:News')
            ->findAll()
        ;

        $view = $this->view($news, 200);

        return $this->handleView($view);
    }

    public function postNewsAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('form', new NewsType(), [
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
}
