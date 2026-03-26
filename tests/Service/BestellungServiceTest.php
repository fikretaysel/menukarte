<?php

namespace App\Tests\Service;

use App\Entity\Bestellung;
use App\Entity\Gericht;
use App\Service\BestellungService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BestellungServiceTest extends TestCase
{
    /** @var EntityManagerInterface&MockObject */
    private $entityManager;
    private BestellungService $service;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->service = new BestellungService($this->entityManager);
    }

    public function testCreateFromGerichtCreatesOpenOrder(): void
    {
        $gericht = (new Gericht())
            ->setName('Pizza')
            ->setPreis(12.5)
            ->setBild('pizza.jpg');

        $reflection = new \ReflectionClass($gericht);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($gericht, 7);

        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');

        $bestellung = $this->service->createFromGericht($gericht, 'tisch9');

        $this->assertInstanceOf(Bestellung::class, $bestellung);
        $this->assertSame('Pizza', $bestellung->getName());
        $this->assertSame('7', $bestellung->getBnummer());
        $this->assertSame(12.5, $bestellung->getPreis());
        $this->assertSame('tisch9', $bestellung->getTisch());
        $this->assertSame(Bestellung::STATUS_OFFEN, $bestellung->getStatus());
    }
}
