<?php

namespace App\Controller;

use App\Entity\Bestellung;
use App\Entity\Gericht;
use App\Repository\BestellungRepository;
use App\Service\BestellungService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestellungController extends AbstractController
{
    /**
     * @Route("/bestellung", name="bestellung", methods={"GET"})
     */
    public function index(BestellungRepository $bestellungRepository): Response
    {
        $bestellungen = $bestellungRepository->findBy(['tisch' => 'tisch1']);

        return $this->render('bestellung/index.html.twig', [
            'bestellungen' => $bestellungen,
        ]);
    }

    /**
     * @Route("/bestellen/{id}", name="bestellen", methods={"GET"})
     */
    public function bestellen(Gericht $gericht, BestellungService $bestellungService): Response
    {
        $bestellung = $bestellungService->createFromGericht($gericht, 'tisch1');

        $this->addFlash('bestell', $bestellung->getName().' wurde zur Bestellung hinzugefügt.');

        return $this->redirectToRoute('menu');
    }

    /**
     * @Route("/status/{id}/{status}", name="status", methods={"GET"})
     */
    public function status(Bestellung $bestellung, string $status, BestellungService $bestellungService): Response
    {
        $bestellungService->updateStatus($bestellung, $status);

        return $this->redirectToRoute('bestellung');
    }

    /**
     * @Route("/loschen/{id}", name="loschen", methods={"GET"})
     */
    public function loschen(Bestellung $bestellung, BestellungService $bestellungService): Response
    {
        $bestellungService->delete($bestellung);

        return $this->redirectToRoute('bestellung');
    }
}
