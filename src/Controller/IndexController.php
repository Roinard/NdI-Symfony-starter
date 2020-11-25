<?php


namespace App\Controller;


use App\Service\DiscordHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="overview_index")
     */
    public function indexAction()
    {
        return $this->render("index.html.twig");
    }
}