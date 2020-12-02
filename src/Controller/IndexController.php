<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render("Index/index.html.twig");
    }


    /**
     *  @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {

        return $this->render("Index/dashboard.html.twig");
    }
}