<?php

namespace App\Controller;

use App\Repository\GerichtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(GerichtRepository $gr)
    {

        $gerichte=$gr->findAll();
        $random=array_rand($gerichte,2);

        return $this->render('home/index.html.twig', [
            'gericht1' => $gerichte[$random[0]],
            'gericht2' => $gerichte[$random[1]]
        ]);
    }
}
