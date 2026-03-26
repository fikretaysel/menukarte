<?php

namespace App\Service;

use App\Entity\Gericht;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GerichtService
{
    private EntityManagerInterface $entityManager;
    private string $bilderOrdner;

    public function __construct(EntityManagerInterface $entityManager, string $bilderOrdner)
    {
        $this->entityManager = $entityManager;
        $this->bilderOrdner = $bilderOrdner;
    }

    public function saveWithImage(Gericht $gericht, ?UploadedFile $bild): Gericht
    {
        if ($bild !== null) {
            $dateiname = md5(uniqid((string) mt_rand(), true)).'.'.$bild->guessExtension();
            $bild->move($this->bilderOrdner, $dateiname);
            $gericht->setBild($dateiname);
        }

        $this->entityManager->persist($gericht);
        $this->entityManager->flush();

        return $gericht;
    }

    public function delete(Gericht $gericht): void
    {
        $this->entityManager->remove($gericht);
        $this->entityManager->flush();
    }
}
