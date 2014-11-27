<?php

namespace Cergy\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @route("/books")
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
}
