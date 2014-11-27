<?php

namespace Cergy\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/create", name="")
     * @Template()
     */
    public function createAction()
    {
        return [];
    }
}