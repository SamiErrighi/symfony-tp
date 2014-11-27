<?php

namespace Cergy\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cergy\NewsBundle\Entity\News;
use Cergy\NewsBundle\Form\Type\NewsType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @route("/news")
 */
class NewsController extends Controller
{
    /**
     * display all news
     *
     * @Route("/", methods={"GET"}, name="news_list")
     * @Template()
     */
    public function indexAction()
    {
        $news = $this->getDoctrine()
            ->getRepository('CergyNewsBundle:News')
            ->findAll()
        ;

        return [
            "news" => $news
        ];
    }

    /**
     * create news
     *
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $news = new News();
        $news->setUser($this->getUser());
        $form = $this->createForm(new NewsType(), $news);
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()) {
                $em =  $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->getFlashBag()->add("success", "sssss");
                return $this->redirect($this->generateUrl('news_lis_'));
            }
        }

        return [
            "form" => $form->createView()
        ];
    }

    /**
     * edit news
     *
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        //get news
        $news = $this->getDoctrine()
            ->getRepository('CergyNewsBundle:News')
            ->find($id)
        ;

        //if news doesn't exist redirect to news
        if(null == $news) {
            $this->get('session')->getFlashBag()->add("success", "news doesn't exist");
            return $this->redirect($this->generateUrl('news_list'));
        }

        $form = $this->createForm(new NewsType(), $news);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);

            if($form->isValid()) {
                $em =  $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->getFlashBag()->add("success", "news update");
                return $this->redirect($this->generateUrl('news_list'));
            }
        }
        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/delete/{id}", methods={"GET"})
     * @Template()
     */
    public function deleteAction($id)
    {
        $news = $this->getDoctrine()
            ->getRepository('CergyNewsBundle:News')
            ->find($id)
        ;

        if(null != $news) {
            $this->get('session')->getFlashBag()->add("success", "news doesn't exist");
            return $this->redirect($this->generateUrl('news_list'));
        }

        $em =  $this->getDoctrine()->getManager();
        $em->remove($news);
        $em->flush();

        $this->get('session')->getFlashBag()->add("success", "news destroy");
        return $this->redirect($this->generateUrl('news_list'));
    }
}
