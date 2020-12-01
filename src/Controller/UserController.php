<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{

    /**
     * @Route("/profile", name="profile")
     */
    public function profileAction(Request $request)
    {
        return $this->render("User/profile.html.twig");
    }

}