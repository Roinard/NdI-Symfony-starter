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

    public function dashboardAction()
    {
        if(!$this->getUser())
            $this->addFlash("danger", "Tu n'as pas le droit d'acceder à cette page");
        return $this->render("Index/dashboard.html.twig");
    }
}