<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Form\GerichtType;
use App\Repository\GerichtRepository;
use Doctrine\Persistence\ManagerRegistry;
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
     * @Route("/", name="bearbeiten")
     */
    public function index(GerichtRepository $gr): Response
    {
        $gerichte=$gr->findAll();

        return $this->render('gericht/index.html.twig', [
            'gerichte' => $gerichte,
        ]);
    }

    /**
     * @Route("/anlegen", name="anlegen")
     */
    public function anlegen(Request $request,ManagerRegistry $doctrine)  {
        $gericht=new Gericht();

        $form=$this->createForm(GerichtType::class, $gericht); // tabloyu entity ile eşleştiriyoruz.
        $form->handleRequest($request);

        if($form->isSubmitted()){
            //Entity Manager
            $em = $doctrine->getManager();
           // $bild=$request->files->get('gericht')['anhang']; //Alternatif olarak yazılabilir.
            $bild=$form->get('bild')->getData();

            if($bild){
                $dateiname=md5(uniqid()).'.'.$bild->guessClientExtension();
            }

            $bild->move(
                $this->getParameter('bilder_ordner'),
                $dateiname
            );

            $gericht->setBild($dateiname);
            $em->persist($gericht);
            $em->flush();

            return $this->redirect($this->generateUrl('gericht.bearbeiten'));
        }

      //  $gericht->setName('Pizza');

//        return new Response("Gericht wurde anlegen.");
        return $this->render('gericht/anlegen.html.twig', [
            'anlegenForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/entfernen/{id}", name="entfernen")
     */
    public function entfernen($id, GerichtRepository $gr,ManagerRegistry $doctrine)  {
        $em=$doctrine->getManager();
        $gericht=$gr->find($id);
        $em->remove($gericht);
        $em->flush();

        //message
        $this->addFlash('erfolg','Gericht wurde erfolgreich entfernt');

        return $this->redirect($this->generateUrl('gericht.bearbeiten'));
    }


    /**
     * @Route("/anzeigen/{id}", name="anzeigen")
     */
    public function anzeigen( Gericht $gericht) {
//        print_r($gericht);
        return $this->render('gericht/anzeigen.html.twig', [
            'gericht' => $gericht,
        ]);
    }
}
