<?php

namespace App\Service;

use App\Entity\Bestellung;
use App\Entity\Gericht;
use Doctrine\ORM\EntityManagerInterface;

class BestellungService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createFromGericht(Gericht $gericht, string $tisch = 'tisch1'): Bestellung
    {
        $bestellung = new Bestellung();
        $bestellung->setTisch($tisch);
        $bestellung->setName($gericht->getName());
        $bestellung->setBnummer((string) $gericht->getId());
        $bestellung->setPreis($gericht->getPreis());
        $bestellung->setStatus(Bestellung::STATUS_OFFEN);

        $this->entityManager->persist($bestellung);
        $this->entityManager->flush();

        return $bestellung;
    }

    public function updateStatus(Bestellung $bestellung, string $status): Bestellung
    {
        $bestellung->setStatus($status);
        $this->entityManager->flush();

        return $bestellung;
    }

    public function delete(Bestellung $bestellung): void
    {
        $this->entityManager->remove($bestellung);
        $this->entityManager->flush();
    }
}
