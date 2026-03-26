<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Form\GerichtType;
use App\Repository\GerichtRepository;
use App\Service\GerichtService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gericht", name="gericht.")
 */
class GerichtController extends AbstractController
{
    /**
     * @Route("/", name="bearbeiten", methods={"GET"})
     */
    public function index(GerichtRepository $gerichtRepository): Response
    {
        return $this->render('gericht/index.html.twig', [
            'gerichte' => $gerichtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/anlegen", name="anlegen", methods={"GET", "POST"})
     */
    public function anlegen(Request $request, GerichtService $gerichtService): Response
    {
        $gericht = new Gericht();
        $form = $this->createForm(GerichtType::class, $gericht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bild = $form->get('bild')->getData();
            $gerichtService->saveWithImage($gericht, $bild);

            $this->addFlash('erfolg', 'Gericht wurde erfolgreich angelegt.');

            return $this->redirectToRoute('gericht.bearbeiten');
        }

        return $this->render('gericht/anlegen.html.twig', [
            'anlegenForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/entfernen/{id}", name="entfernen", methods={"GET"})
     */
    public function entfernen(Gericht $gericht, GerichtService $gerichtService): Response
    {
        $gerichtService->delete($gericht);
        $this->addFlash('erfolg', 'Gericht wurde erfolgreich entfernt');

        return $this->redirectToRoute('gericht.bearbeiten');
    }

    /**
     * @Route("/anzeigen/{id}", name="anzeigen", methods={"GET"})
     */
    public function anzeigen(Gericht $gericht): Response
    {
        return $this->render('gericht/anzeigen.html.twig', [
            'gericht' => $gericht,
        ]);
    }

    /**
     * @Route("/preis/{id}", name="preis", methods={"GET"})
     */
    public function preis(int $id, GerichtRepository $gerichtRepository): Response
    {
        $gericht = $gerichtRepository->find5Euro($id);

        return $this->json($gericht);
    }
}
